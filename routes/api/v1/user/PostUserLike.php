<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\User\PostUserLikeController;

Route::prefix('PostUserLike')->controller(PostUserLikeController::class)->group(function () {
    Route::get('/','index');
    Route::post('/', 'store');
    Route::delete('/{postUserLike}', 'destroy');
});
