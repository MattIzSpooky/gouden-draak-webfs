<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('API')->group(function () {
    Route::apiResource('news', 'NewsController');

    Route::namespace('Auth')->group(function () {
        Route::post('/login', 'LoginController')->name('login');
        Route::post('/logout', 'LogoutController')->middleware(['auth:sanctum'])->name('logout');
    });

    Route::middleware('auth:sanctum')->get('/user', function () {
        return 'Succes';
    });
});
