<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\User\PostController;

Route::prefix('Post')->controller(PostController::class)->group(function () {
    Route::get('/','index');
    Route::get('/{id}','show');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::delete('/{post}', 'destroy');
});
