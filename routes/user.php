<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthenticationController;
use App\Http\Controllers\User\ServiceProviderController;

Route::post('/check_phone_number_existence',[AuthenticationController::class,'checkPhoneNumberExistence']);
Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/verify_code',[AuthenticationController::class,'verify']);
Route::post('/resend_code',[AuthenticationController::class,'resend']);
Route::post('/login',[AuthenticationController::class,'login']);

Route::controller(ServiceProviderController::class)->middleware('auth:user')->group(function(){
  Route::get('/services/{latitude}/{longitude}','listOfServices');
});