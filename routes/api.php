<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionController;

Route::controller(AuthController::class)->group(function () {
  Route::post('/login', 'Login');
  Route::post('/or', 'ORCheck');
  Route::post('/register', 'Register');
});
Route::apiResource('/address', AddressController::class)->only(['index']);


Route::middleware('auth:sanctum')->group(function () {
  Route::controller(AuthController::class)->group(function () {
    Route::post('/change-password', 'ChangePassword');
    Route::post('/avatar', 'ChangeAvatar');
  });

  Route::apiResource('/users', UserController::class)->only(['index', 'destroy', 'store', 'update']);
  Route::apiResource('/dashboard', DashboardController::class)->only(['index']);
  Route::apiResource('/plan', PlanController::class)->only(['index', 'destroy', 'store', 'update']);
  Route::apiResource('/role', RoleController::class)->only(['index']);
  Route::apiResource('/transactions', TransactionController::class)->only(['index']);
});
