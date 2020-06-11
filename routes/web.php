<?php

use Illuminate\Support\Facades\Route;

Route::any('/{any}', 'FrontendController')->where('any', '^(?!api).*$');
