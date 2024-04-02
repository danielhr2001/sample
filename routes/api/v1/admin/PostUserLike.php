<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Admin\PostUserLikeController;

Route::prefix('PostUserLike')->controller(PostUserLikeController::class)->group(function () {
    Route::get('/','index');
    Route::get('{postUserLike}','show');
    Route::post('/', 'store');
    Route::put('/{postUserLike}', 'update');
    Route::delete('/{postUserLike}', 'destroy');
});
