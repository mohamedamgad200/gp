<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\App\Http\Controllers\PostController;

Route::prefix('doctor')->middleware('auth:doctor_api')->group(function () {
    Route::apiResource('posts',PostController::class);
});
Route::prefix('patient')->middleware('auth:patient_api')->group(function () {
    Route::apiResource('posts',PostController::class);
});
