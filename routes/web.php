<?php

use Illuminate\Support\Facades\Route;


Route::get('/login', function () {
    return response()->json(["message" => "لطفا لاگین کنید"], 401);
})->name('login');

Route::fallback(function () {
    return response()->json(["message" => "آدرس مد نظر پیدا نشد"], 404);
});
