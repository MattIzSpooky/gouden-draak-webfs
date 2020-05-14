<?php

use Illuminate\Support\Facades\Route;

Route::any('/{any}', 'FrontendController@app')->where('any', '^(?!api).*$');
