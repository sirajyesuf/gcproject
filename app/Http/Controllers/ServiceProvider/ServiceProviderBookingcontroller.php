<?php

namespace App\Http\Controllers\ServiceProvider;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookingResourceCollection;

class ServiceProviderBookingcontroller extends Controller
{
    private $serviceProvider;

    public function __construct()
    {
        $this->serviceProvider = Auth::guard('service_provider')->user();

    }
    public function toBeDoneBookings()
    {
        $toBeDoneBookings = $this->serviceProvider->bookings()->orderBy('service_date','DESC')->orderBy('created_at','DESC')->where('status',1)->paginate(15);
        $resourse = (new BookingResourceCollection($toBeDoneBookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function completedBookings()
    {
        $completed = $this->serviceProvider->bookings()->orderBy('service_date','DESC')->orderBy('created_at','DESC')->where('status',2)->paginate(15);
        $resourse = (new BookingResourceCollection($completed));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function allBookings()
    {
        $completed = $this->serviceProvider->bookings()->orderBy('service_date','DESC')->orderBy('created_at','DESC')->paginate(15);
        $resourse = (new BookingResourceCollection($completed));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function todayToBeDoneBookings()
    {
        $todayToBeDoneBookings = $this->serviceProvider->bookings()->orderBy('service_date','DESC')
        ->orderBy('created_at','DESC')->whereDate('service_date',Carbon::today())->where('status',1)->paginate(15);
        $resourse = (new BookingResourceCollection($todayToBeDoneBookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function todayCompletedBookings()
    {
        $todayCompletedBookings = $this->serviceProvider->bookings()->orderBy('service_date','DESC')
        ->orderBy('created_at','DESC')->whereDate('service_date',Carbon::today())->where('status',2)->paginate(15);
        $resourse = (new BookingResourceCollection($todayCompletedBookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function todayAllBookings()
    {
        $todayAllBookings = $this->serviceProvider->bookings()->orderBy('service_date','DESC')
        ->orderBy('created_at','DESC')->whereDate('service_date',Carbon::today())->paginate(15);
        $resourse = (new BookingResourceCollection($todayAllBookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }
    
}
