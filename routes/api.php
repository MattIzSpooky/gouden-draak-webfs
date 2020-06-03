<?php

namespace App;

use Illuminate\Support\Facades\Route;

Route::namespace('API')->group(function () {
    Route::get('news', 'NewsController@index')->name('news.index');
    Route::post('orders', 'OrderController@store')->name('orders.store');

    Route::namespace('Auth')->group(function () {
        Route::post('/login', 'LoginController')->name('login');
        Route::post('/logout', 'LogoutController')->middleware(['auth:sanctum'])->name('logout');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', 'InfoController')->name('auth.user');

        Route::prefix('dish')->name('dish.')->group(function () {
            Route::get('types', 'DishTypeController')->name('types');
            Route::get('additions', 'MenuAdditionController')->name('additions');
        });

        Route::apiResource('news', 'NewsController')->except('index')->middleware('role:admin');
        Route::apiResource('menu', 'MenuItemController')->middleware('role:admin');
        Route::get('users/roles', 'RoleController')->name('users.roles')->middleware('role:admin');
        Route::apiResource('users', 'UserController')->middleware('role:admin');
        Route::apiResource('orders', 'OrderController')->except(['destroy', 'store'])->middleware('role:admin,waitress,kassa');
    });
});
