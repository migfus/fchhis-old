<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
  $data = [
    'link' => 'https://google.com',
    'code' => 123,
  ];
  return view('mail.forgot-password')->with($data);
});

Route::get('{any}', function () {
    return view('vue-app');
})->where('any', '.*');
