<?php

use App\Http\Controllers\API\V1\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('post')->controller(PostController::class)->group('/', function () {
    Route::get('/','index');
    Route::get('/{post}','show');
    Route::post('/','store');
    Route::put('/{post}','update');
    Route::delete('/{post}','destroy');
});
