<?php

use App\Http\Controllers\API\V1\PostUserLikeController;
use Illuminate\Support\Facades\Route;

Route::prefix('post_user_like')->controller(PostUserLikeController::class)->group('/', function () {
    Route::get('/','index');
    Route::get('/{postUserLike}','show');
    Route::post('/','store');
    Route::put('/{postUserLike}','update');
    Route::delete('/{postUserLike}','destroy');
});
