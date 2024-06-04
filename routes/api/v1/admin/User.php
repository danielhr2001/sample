<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Admin\UserController;

Route::prefix('User')->controller(UserController::class)->group(function () {
    Route::get('/','index');
    Route::get('{id}','show');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
});
