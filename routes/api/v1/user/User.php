<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\User\UserController;

Route::prefix('User')->controller(UserController::class)->group(function () {
    Route::put('/', 'update');
});
