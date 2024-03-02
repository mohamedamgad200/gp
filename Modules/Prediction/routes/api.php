<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Prediction\App\Http\Controllers\PredictionController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:patient_api'])->group(function () {
    Route::post('patient/survey/predict', [PredictionController::class,'predict']);
});
