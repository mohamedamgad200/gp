<?php

use App\Models\Patient;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Statistics\App\Http\Controllers\StatisticsController;

Route::middleware(['auth:doctor_api'])->prefix('doctor')->group(function () {
    Route::get('statistics',[StatisticsController::class,'statistics']);
});
