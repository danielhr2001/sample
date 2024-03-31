<?php

use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->controller(UserController::class)->group('/', function () {
    Route::get('/','index');
    Route::get('/{user}','show');
    Route::post('/','store');
    Route::put('/{user}','update');
    Route::delete('/{user}','destroy');
});
