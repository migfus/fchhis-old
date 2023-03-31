<?php

use Illuminate\Support\Facades\Route;

Route::get('{any}', function () {
    return view('vue-app');
})->where('any', '.*');
