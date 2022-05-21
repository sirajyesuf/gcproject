<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BookingRequest;
use App\Models\Booking;
use App\Models\Deposit;
use App\Models\Service;
use App\Models\User;
use App\Services\GeneralServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
     public function booking(BookingRequest $bookingRequest)
     {
         $input = $bookingRequest->only('service_date','service_id');
         $user = Auth::guard('user')->user();
         $generalService = new GeneralServices;
         $balance = $generalService->userBalance($user);
         $service = Service::findOrFail($input['service_id']);
         if($service->price > $balance){
             return response()->json(['status'=>'failed','message'=>'insufficient balance'],Response::HTTP_ACCEPTED);
         }
         $service_date                    =   Carbon::parse($input['service_date']);
         $input['service_provider_id']    =   $service->service_provider_id;
         $input['service_date']           =   $service_date;
         $input['status']                 =   1;

         $booking = $user->bookings()->create($input);
         return response()->json($booking,Response::HTTP_CREATED);
     }

     public function checkBookingEligibility($service_id)
     {
        $user = Auth::guard('user')->user();
        $check = (new GeneralServices)->checkUserBookingEligibilty($user,$service_id);
        return response()->json(['status'=>$check],Response::HTTP_OK);  
     }
}
