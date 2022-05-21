<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index()
     {
         //return total earning,total paid,total booking;
         //list of today bookings;
         $total_earning = DB::table('bookings')->select('bookings.id','bookings.service_provider_id','services.id','services.price','services.service_provider_id')
                          ->leftJoin('services','services.service_provider_id','bookings.service_provider_id')
                          ->sum('services.price');

     }
}
