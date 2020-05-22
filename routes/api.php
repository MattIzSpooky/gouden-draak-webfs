<?php

namespace App;

use Illuminate\Support\Facades\Route;

Route::namespace('API')->group(function () {
    Route::apiResource('news', 'NewsController');
    Route::post('orders', 'OrderController@store');
    Route::get('orders/{order}', 'OrderController@show');

    Route::namespace('Auth')->group(function () {
        Route::post('/login', 'LoginController')->name('login');
        Route::post('/logout', 'LogoutController')->middleware(['auth:sanctum'])->name('logout');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('info', function () {
            // FIXME: temporary fix for feature tests
            return 'You are logged in!';
        });
        Route::prefix('dish')->name('dish.')->group(function () {
            Route::get('types', 'DishTypeController')->name('types');
            Route::get('additions', 'MenuAdditionController')->name('additions');
        });
        Route::apiResource('menu', 'MenuItemController');
        Route::get('orders', 'OrderController@index');
    });
});
