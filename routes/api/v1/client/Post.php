<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Client\PostController;

Route::prefix('Post')->controller(PostController::class)->group(function () {
    Route::get('/','index');
    Route::get('{post}','show');
});
