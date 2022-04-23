<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceProvider\AuthenticationController;

Route::controller(AuthenticationController::class)->group(function(){
    Route::post('/check_phone_number_existence','checkPhoneNumberExistence');
    Route::post('/register',[AuthenticationController::class,'register']);
    Route::post('/login',[AuthenticationController::class,'login']);
    Route::post('/resend_code',[AuthenticationController::class,'resend']);



});
