<?php

namespace App\Http\Controllers\ServiceProvider;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookingResourceCollection;
use App\Models\Booking;

class ServiceProviderBookingcontroller extends Controller
{
    private $serviceProvider;

    public function __construct()
    {
        $this->serviceProvider = Auth::guard('service_provider')->user();

    }
    public function toBeDoneBookings()
    {
        $bookings = Booking::with(['user','service'])->ofServiceProviderBooking($this->serviceProvider->id,null,1)->paginate(15);
        $resourse = (new BookingResourceCollection($bookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function completedBookings()
    {
        $bookings = Booking::with(['user','service'])->ofServiceProviderBooking($this->serviceProvider->id,null,2)->paginate(15);
        $resourse = (new BookingResourceCollection($bookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function allBookings()
    {
        $bookings = Booking::with(['user','service'])->ofServiceProviderBooking($this->serviceProvider->id)->paginate(15);
        $resourse = (new BookingResourceCollection($bookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function todayToBeDoneBookings()
    {
        $bookings = Booking::with(['user','service'])
        ->ofServiceProviderBooking($this->serviceProvider->id,true,1)->paginate(15);
        $resourse = (new BookingResourceCollection($bookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function todayCompletedBookings()
    {
        $bookings = Booking::with(['user','service'])
        ->ofServiceProviderBooking($this->serviceProvider->id,true,2)->paginate(15);
        $resourse = (new BookingResourceCollection($bookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }

    public function todayAllBookings()
    {
        $bookings = Booking::with(['user','service'])
        ->ofServiceProviderBooking($this->serviceProvider->id,true,2)->paginate(15);
        $resourse = (new BookingResourceCollection($bookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
    }
    
}
