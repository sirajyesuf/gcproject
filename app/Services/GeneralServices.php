<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
                $price = Service::where('id',$book->service_id)->first()->price;
                $sum+=$price;
            }
        }
        
        return $sum;
   }

   public function userDeposit($user)
   {
      if($user->deposits){
          return $user->deposits()->where('status',true)->sum('amount');
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
}
