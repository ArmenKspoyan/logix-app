<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth/')->group(function (){
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('settings')->group(function () {
        Route::post('/password/change', [UserController::class, 'changePassword']);
        Route::get('/password/reset-password-link', [UserController::class, 'resetPasswordLink']);

        Route::post('/email/change', [UserController::class, 'changeEmail']);
        Route::post('/email/change/confirm', [UserController::class, 'changeEmailConfirm']);


    });
});

