<?php

namespace App;

use Illuminate\Support\Facades\Route;

Route::namespace('API')->group(function () {
    Route::get('news', 'NewsController@index')->name('news.index');
    Route::get('promotions', 'PromotionalDiscountsController@view')->name('discounts.view');
    Route::get('menu', 'MenuItemController@index')->name('menu.index');
    Route::get('menu/filter', 'MenuItemController@filter')->name('menu.filter');
    Route::post('orders', 'OrderController@store')->name('orders.store');

    Route::namespace('Auth')->group(function () {
        Route::post('/login', 'LoginController')->name('login');
        Route::post('/logout', 'LogoutController')->middleware(['auth:sanctum'])->name('logout');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', 'InfoController')->name('auth.user');

        Route::prefix('dish')->name('dish.')->group(function () {
            Route::get('', 'DishController')->name('index');
            Route::get('types', 'DishTypeController')->name('types');
            Route::get('additions', 'MenuAdditionController')->name('additions');
        });

        Route::apiResource('promotions/discounts', 'PromotionalDiscountsController')->middleware('role:admin,waitress');

        Route::apiResource('news', 'NewsController')->except('index')->middleware('role:admin');

        Route::get('users/roles', 'RoleController')->name('users.roles')->middleware('role:admin');
        Route::apiResource('users', 'UserController')->middleware('role:admin');

        Route::middleware('role:admin')->group(function () {
            Route::post('menu/restore/{id}', 'MenuItemController@restore')->name('menu.restore');
            Route::get('menu/with-trashed', 'MenuItemController@allWithThrashed')->name('menu.all-with-trashed');
            Route::apiResource('menu', 'MenuItemController')->except('index');
        });

        Route::middleware('role:admin,waitress,kassa')->group(function () {
            Route::get('orders/filter', 'OrderController@filter')->name('orders.filter');
            Route::apiResource('orders', 'OrderController')->except(['destroy', 'store']);
        });
    });
});
