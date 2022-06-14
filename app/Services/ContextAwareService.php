<?php

namespace  App\Services;
use App\Models\User;
use App\Models\Booking;
use App\Services\GeneralServices;
use Carbon\Carbon;

class ContextAwareService
{
  public function __invoke()
  {
    $users = User::all();
    foreach($users as $user){
        $bookings = Booking::where('user_id',$user->id)->get();
        $initial_date = null;
        $intervals = [];
        \Log::info("user ".$user->name." is running");
        foreach($bookings as $booking){
            if($initial_date == null){
              $initial_date = Carbon::parse($booking->service_date);
              $final_date   = Carbon::parse($booking->service_date);
            }else{
                $final_date = Carbon::parse($booking->service_date);
                $difference =  $initial_date->diffInDays($final_date);
                array_push($intervals,$difference);
                $initial_date = $final_date;
            }
        }
        \Log::info("intervals".print_r($intervals));

        if(!empty($intervals) && count($intervals) > 1){
          $initial = null;  
          $recommend = 0;
          $no_recommend = 0;
          $sum = 0;
          foreach($intervals as $interval){
             if($initial == null){
                $initial = $interval;
                continue;
             }
             $value = $initial-$interval;
             if(abs($value) <= 2 ){
               $recommend++;
               $sum+=$value;
             }else{
                $no_recommend++;
             }

          }
          continue;
          if($recommend > $no_recommend){
            $average_day = $sum/$recommend;
            $next = $final_date->addDays($average_day);
            $title = 'your salon and spa is coming'."\n";
            $body = 'your salon and spa routine will be on the '.$next;
            $message = $title.$body;
            $service = new GeneralServices();
            $service->sendSms($user->phone_number,$message);
          }
          
        }
    }
  }
}