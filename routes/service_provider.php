<?php

use App\Http\Controllers\ServiceApprovalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceProvider\AuthenticationController;
use App\Http\Controllers\ServiceProvider\DashboardController;
use App\Http\Controllers\ServiceProvider\RateAndReviewController;
use App\Http\Controllers\ServiceProvider\ReportController;
use App\Http\Controllers\ServiceProvider\ServiceController;
use App\Http\Controllers\ServiceProvider\ServiceProviderBookingcontroller;
use App\Http\Controllers\ServiceProvider\ServiceProviderPaymentController;
use App\Http\Controllers\ServiceProvider\ServiceProviderProfileController;
use App\Http\Controllers\ServiceProvider\WithdrawController;

Route::controller(AuthenticationController::class)->group(function(){
    Route::post('/check_phone_number_existence','checkPhoneNumberExistence');
    Route::post('/register',[AuthenticationController::class,'register']);
    Route::post('/login',[AuthenticationController::class,'login']);
    Route::post('/resend_code',[AuthenticationController::class,'resend']);
});

Route::controller(ServiceController::class)->middleware('auth:service_provider')->group(function(){
   Route::post('/add_service','addService');
   Route::get('/all_services','allServices');
   Route::post('/edit_service/{id}','editService');
   Route::get('/delete_service/{id}','deleteService');
});

Route::controller(ServiceProviderProfileController::class)->middleware('auth:service_provider')->group(function(){
   Route::get('/profile','profile');
   Route::post('/edit_profile','editProfile');
   Route::get('/log_out','logOut');
 });

 Route::controller(DashboardController::class)->middleware('auth:service_provider')->group(function(){
    Route::get('/dashboard','index');   
  });

  Route::controller(RateAndReviewController::class)->middleware('auth:service_provider')->group(function(){
    Route::get('/reviews','reviews');   
  });

  Route::controller(ServiceProviderBookingcontroller::class)->middleware('auth:service_provider')->group(function(){
    Route::get('/completed_bookings','completedBookings');
    Route::get('/to_be_done_bookings','toBeDoneBookings');
    Route::get('/all_bookings','allBookings');

    //

    Route::get('/today_completed_bookings','todayCompletedBookings');
    Route::get('/today_to_be_done_bookings','todayToBeDoneBookings');
    Route::get('/today_all_bookings','todayAllBookings');

  });

  Route::controller(ServiceProviderPaymentController::class)->middleware('auth:service_provider')->group(function(){
    Route::post('/add_payment','addPaymentMethod');   
    Route::post('/edit_payment_method/{id}','editPaymentMethod');
    Route::get('get_payment_method','getPaymentMethod');
  });

  Route::controller(WithdrawController::class)->middleware('auth:service_provider')->group(function(){
    Route::post('/withdraw_request','askWithDraw');   
    Route::get('/withdraw_data/{id}','withdraw');
    Route::get('/withdraws','withdraws');
  });

  Route::controller(ReportController::class)->middleware('auth:service_provider')->group(function(){
     Route::get('/earnings','earnings');       
  });

  Route::controller(ServiceApprovalController::class)->middleware('auth:service_provider')->group(function(){
    Route::post('approve_service/{booking_id}','approveService');
  });
