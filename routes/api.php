<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// SECTION PUBLIC API
Route::group(['prefix' => 'public', 'as' => 'public.'], function() {
    // NOTE FOR BACKEND TESTING ONLY.
    Route::apiResource('/test', \App\Http\Controllers\Public\TestPublicController::class)->only(['index']);
    Route::apiResource('/address', \App\Http\Controllers\Public\AddressPublicController::class)->only(['index']);
});



// SECTION AUTHENTICATION
Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post('/login', 'Login');
    Route::post('/or', 'ORCheck');
    Route::post('/register', 'Register');
    Route::post('/recovery', 'Recovery');
    Route::post('/recovery-confirm', 'ConfirmRecovery');
    Route::post('/change-password-recovery', 'ChangePasswordRecovery');
});



// SECTION USER API
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
        Route::get('/profile', 'Profile');
        Route::get('/overdue', 'Overdue');
        Route::post('/change-password', 'ChangePassword');
        Route::post('/avatar', 'ChangeAvatar');
        Route::post('/claim/{id}', 'Claim');
    });

        Route::get('/users/dashboard', [\App\Http\Controllers\UserController::class, 'dashboard']);
    Route::apiResource('/users',     \App\Http\Controllers\UserController::class)->only(['index', 'destroy', 'store', 'update', 'show']);
    Route::apiResource('/dashboard', \App\Http\Controllers\DashboardController::class)->only(['index']);
    Route::apiResource('/plan',      \App\Http\Controllers\PlanController::class)->only(['index', 'destroy', 'store', 'update']);
    Route::apiResource('/role',      \App\Http\Controllers\RoleController::class)->only(['index']);
    Route::apiResource('/transaction', \App\Http\Controllers\TransactionController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::apiResource('/beneficiary', \App\Http\Controllers\BeneficiaryController::class)->only(['index', 'destroy', 'store', 'update']);
    Route::apiResource('/downhead',  \App\Http\Controllers\DownHeadController::class)->only(['index']);
    Route::apiResource('/client',    \App\Http\Controllers\ClientController::class)->only(['index']);
    Route::apiResource('/pay-type',  \App\Http\Controllers\PayTypeController::class)->only(['index']);
    Route::apiResource('/agent',     \App\Http\Controllers\AgentController::class)->only(['index']);
    Route::apiResource('/statistic', \App\Http\Controllers\StatisticController::class)->only(['index']);
});
