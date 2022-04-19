<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthenticationController;

Route::post('/check_phone_number_existence',[AuthenticationController::class,'checkPhoneNumberExistence']);
Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/verify_code',[AuthenticationController::class,'verify']);
Route::post('/resend_code',[AuthenticationController::class,'resend']);
Route::post('/login',[AuthenticationController::class,'login']);