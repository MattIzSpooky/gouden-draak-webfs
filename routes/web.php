<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::any('/{any}', 'FrontendController@app')->where('any', '^(?!api).*$');
