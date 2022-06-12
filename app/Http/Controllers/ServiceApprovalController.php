<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Booking;
use Illuminate\Http\Response;

class ServiceApprovalController extends Controller
{
    public function generateBarcodeForUser($booking_id)
    {
      $token = Str::uuid();
      $booking = Booking::findOrFail($booking_id);
      if($booking->draft){
        return response()->json(['status'=>'fail'],Response::HTTP_ACCEPTED);
      }
      $booking->update([
        'approval_token' => $token,
      ]);
      return response()->json(['approval_token'=>$token],Response::HTTP_OK);
    }

    public function approveService(Request $request, $booking_id)
    {
       $booking = Booking::findOrFail($booking_id); 
       $request->validate([
        'approval_token' => 'required'
       ]);
       if($request->approval_token == $booking->approval_token){
         $booking->update(['status'=>2]);
         return response()->json(['status'=>'approved','book'=>$booking],Response::HTTP_OK);
       }else{
         return response()->json(['status'=>'fail'],Response::HTTP_ACCEPTED);
       }
    }


}
