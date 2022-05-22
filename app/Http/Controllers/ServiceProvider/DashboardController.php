<?php

namespace App\Http\Controllers\ServiceProvider;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\GeneralServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookingResourceCollection;

class DashboardController extends Controller
{
     public function index()
     {
        $serviceProvider = Auth::guard('service_provider')->user();
        $generalData = [
          'rate'=>(new GeneralServices)->calculateAverageRate($serviceProvider->id),
          'total_booking'=>(new GeneralServices)->serviceProviderTotalBooking($serviceProvider),
          'today_total_booking'=>(new GeneralServices)->serviceProviderTodayTotalBooking($serviceProvider),
          'total_balance'=>(new GeneralServices)->serviceProviderTotalBalance($serviceProvider),
        ];
        return response()->json($generalData,Response::HTTP_OK);

     }
}
