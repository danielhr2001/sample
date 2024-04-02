<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;

Route::prefix('Auth')->controller(AuthController::class)->group(function () {
    Route::post('/login_register_by_phone', 'phoneChecker');
    Route::post('/otp_verification', 'OTPVerification');
    Route::post('/login_by_password', 'loginByPassword');
    Route::post('/logout', 'logout');
    Route::get('/user_info', 'userInfo');
});
