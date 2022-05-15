<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthenticationController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ServiceController;
use App\Http\Controllers\User\ServiceProviderController;

Route::post('/check_phone_number_existence',[AuthenticationController::class,'checkPhoneNumberExistence']);
Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/verify_code',[AuthenticationController::class,'verify']);
Route::post('/resend_code',[AuthenticationController::class,'resend']);
Route::post('/login',[AuthenticationController::class,'login']);


Route::controller(ServiceProviderController::class)->middleware('auth:user')->group(function(){
  Route::get('/service_providers/{latitude}/{longitude}','listOfServiceProviders');
});

Route::controller(ServiceController::class)->middleware('auth:user')->group(function(){
  Route::get('/services/{service_provider_id}','listOfServices');
});
Route::controller(PaymentController::class)->middleware('auth:user')->group(function(){
 Route::post('/deposit','deposit');
});
