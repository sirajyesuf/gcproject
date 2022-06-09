<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Deposit;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\GeneralServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\BookingRequest;
use App\Http\Resources\BookingResourceCollection;

class BookingController extends Controller
{
     public function booking(BookingRequest $bookingRequest,$deposit_id=null)
     {
         $input = $bookingRequest->only('service_date','service_id');
         $user = Auth::guard('user')->user();
         $generalService = new GeneralServices;
         $balance = $generalService->userBalance($user);
         $service = Service::findOrFail($input['service_id']);
         if($service->price > $balance){
             $input['draft'] = true;
         }
         if($deposit_id != null){
             $input['deposit_id'] = $deposit_id;
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

     public function userBookings()
     {
        $user = Auth::guard('user')->user();
        $bookings = Booking::with(['user','service'])->where('user_id',$user->id)->paginate(15);
        $resourse = (new BookingResourceCollection($bookings));
        return response()->json($resourse->response()->getData(),Response::HTTP_OK);
     }
}
