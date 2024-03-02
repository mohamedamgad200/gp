<?php

use Illuminate\Support\Facades\Route;
use Modules\Authentication\App\Http\Controllers\Doctor\AuthController;
use Modules\Authentication\App\Http\Controllers\Doctor\SocialiteController;
use Modules\Authentication\App\Http\Controllers\Patient\AuthController as PatientAuthController;

Route::prefix('doctor')->group(function(){
    Route::post('signup',[AuthController::class,'signup']);
    Route::post('signin',[AuthController::class,'signin']);
    Route::post('forget-password',[AuthController::class,'forgetPassword']);
    Route::post('reset-password',[AuthController::class,'resetPassword']);
    Route::post('resend-otp',[AuthController::class,'resendOtp']);
});

Route::prefix('doctor')->middleware(['auth:doctor_api'])->group(function(){
    Route::get('profile',[AuthController::class,'profile']);
    Route::post('update-profile',[AuthController::class,'updateProfile']);
    Route::delete('delete-profile',[AuthController::class,'deleteProfile']);
    Route::post('change-password',[AuthController::class,'changePassword']);
    Route::post('logout',[AuthController::class,'logout']);
});


Route::prefix('patient')->group(function(){
    Route::post('signup',[PatientAuthController::class,'signup']);//
    Route::post('signin',[PatientAuthController::class,'signin']);//
    Route::post('forget-password',[PatientAuthController::class,'forgetPassword']);//
    Route::post('reset-password',[PatientAuthController::class,'resetPassword']);//
    Route::post('resend-otp',[PatientAuthController::class,'resendOtp']);//
});

Route::prefix('patient')->middleware(['auth:patient_api'])->group(function(){
    Route::get('profile',[PatientAuthController::class,'profile']);//
    Route::post('update-profile',[PatientAuthController::class,'updateProfile']);//
    Route::delete('delete-profile',[PatientAuthController::class,'deleteProfile']);//
    Route::post('change-password',[PatientAuthController::class,'changePassword']);//
    Route::post('logout',[PatientAuthController::class,'logout']);//
});

// google socialite login
Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);