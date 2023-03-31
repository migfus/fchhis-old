<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
  Route::post('/login', 'Login');
});

Route::middleware('auth:sanctum')->group(function () {
  Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post('/change-password', 'ChangePassword');
  });
});
