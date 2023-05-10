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
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DownHeadController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PayTypeController;
use App\Http\Controllers\AgentController;

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
    Route::get('/profile', 'Profile');
  });

  Route::apiResource('/users', UserController::class)->only(['index', 'destroy', 'store', 'update']);
  Route::apiResource('/dashboard', DashboardController::class)->only(['index']);
  Route::apiResource('/plan', PlanController::class)->only(['index', 'destroy', 'store', 'update']);
  Route::apiResource('/role', RoleController::class)->only(['index']);
  Route::apiResource('/transactions', TransactionController::class)->only(['index', 'store']);
  Route::apiResource('/beneficiary', BeneficiaryController::class)->only(['index', 'destroy', 'store', 'update']);
  Route::apiResource('/downhead', DownHeadController::class)->only(['index']);
  Route::apiResource('/client', ClientController::class)->only(['index']);
  Route::apiResource('/pay-type', PayTypeController::class)->only(['index']);
  Route::apiResource('/agent', AgentController::class)->only(['index']);
});
