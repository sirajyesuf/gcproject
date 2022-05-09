<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceProvider\AuthenticationController;
use App\Http\Controllers\ServiceProvider\ServiceController;

Route::controller(AuthenticationController::class)->group(function(){
    Route::post('/check_phone_number_existence','checkPhoneNumberExistence');
    Route::post('/register',[AuthenticationController::class,'register']);
    Route::post('/login',[AuthenticationController::class,'login']);
    Route::post('/resend_code',[AuthenticationController::class,'resend']);
});

Route::controller(ServiceController::class)->middleware('auth:service_provider')->group(function(){
   Route::post('/add_service','addService');
});
