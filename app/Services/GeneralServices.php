<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\User\RateAndReview;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralServices
{
   public function userBalance($user)
   {
      return ($this->userDeposit($user) - $this->userExpense($user));
   }

   public function userExpense($user)
   {    $sum = 0;
        
        if($user->bookings){
            foreach($user->bookings as $book){
                if($book->draft){
                    continue;
                }
                $price = Service::where('id',$book->service_id)->first()->price;
                $sum+=$price;
            }
        }
        
        return $sum;
   }

   public function userDeposit($user)
   {
      if($user->deposits){
          return $user->deposits()->where('status',2)->sum('amount');
      }
      return 0;
   }

   public function checkUserBookingEligibilty($user,$service_id)
   {
      $userBalance = $this->userBalance($user);
      $service = Service::findOrFail($service_id);
      if($service->price > $userBalance){
          return false;
      }
      return true;
   }

   public function calculateAverageRate($service_provider_id)
   {
      $total = RateAndReview::where('service_provider_id',$service_provider_id)->sum('rate');
      $count = RateAndReview::where('service_provider_id',$service_provider_id)->count();
      if($count==0)      return number_format(0,2);
      $average = number_format(($total/$count),2);
      return $average;
   }

   public function serviceProviderTotalEarning($serviceProvider)
   {
    $sum = 0;
    $bookings = $serviceProvider->bookings()->where('status',2)->where('draft',false)->get();    
    if($bookings){
        foreach($bookings as $book){
            $price = Service::where('id',$book->service_id)->first()->price;
            $sum+=$price;
        }
    }
    
    return $sum; 
   }

   public function serviceProviderTotalBalance($serviceProvider)
   {
      $earning  = $this->serviceProviderTotalEarning($serviceProvider);
      $service_fee = $this->serviceProviderTotalFee($serviceProvider);
      $withdraw   = Withdraw::where('service_provider_id',$serviceProvider->id)->where('status',3)->sum('amount');
      $balance = $earning-$service_fee-$withdraw; 
      return $balance;
   }

   public function serviceProviderTotalFee($serviceProvider)
   {
        $earning  = $this->serviceProviderTotalEarning($serviceProvider);
        return ($earning*5)/100;
   }

   public function serviceProviderTodayTotalBooking($serviceProvider)
   {
       return $serviceProvider->bookings()->whereDate('service_date',Carbon::today())->count();
   }

   public function serviceProviderTotalBooking($serviceProvider)
   {
       return $serviceProvider->bookings()->count();
   }

   public function totalWithdraw($serviceProvider)
   {
     return $serviceProvider->withdraws()->where('status',3)->sum('amount');
   }

   public function sendSms($phone_number,$message)
   {
       $url = 'https://sms.hahucloud.com/api/send';
       $parametres = [
           'key'     => '9eb2f7e2bfe6b1e496578f32c0b1e311d58b67c1',
           'phone'   => $phone_number,
           'message' => $message,
       ];
       $send_sms = Http::get($url,$parametres);
       if($send_sms->status() == 200){
           return true;
       }
       return false;
   }

}
