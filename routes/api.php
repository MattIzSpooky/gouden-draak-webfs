<?php

use Illuminate\Support\Facades\Route;

Route::namespace('API')->group(function () {
    Route::apiResource('news', 'NewsController');

    Route::namespace('Auth')->group(function () {
        Route::post('/login', 'LoginController')->name('login');
        Route::post('/logout', 'LogoutController')->middleware(['auth:sanctum'])->name('logout');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('dish')->name('dish.')->group(function () {
            Route::get('types', 'DishTypeController')->name('types');
        });
    });
});
