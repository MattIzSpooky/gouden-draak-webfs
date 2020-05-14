<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::namespace('API')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::post('/login', 'LoginController')->name('login');
    });

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});
