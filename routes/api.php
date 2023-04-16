<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
  Route::post('/login', 'Login');
});
Route::apiResource('/address', \App\Http\Controllers\AddressController::class)->only(['index']);

Route::middleware('auth:sanctum')->group(function () {
  Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post('/change-password', 'ChangePassword');
    Route::post('/avatar', 'ChangeAvatar');
  });

  Route::apiResource('/users', \App\Http\Controllers\UserController::class)->only(['index', 'destroy', 'store', 'update']);
  Route::apiResource('/dashboard', \App\Http\Controllers\DashboardController::class)->only(['index']);
  Route::apiResource('/plan', \App\Http\Controllers\PlanController::class)->only(['index']);

});
