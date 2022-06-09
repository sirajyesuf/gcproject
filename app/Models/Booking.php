<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory,Uuids;
    
    protected $guarded = [];

    public function scopeOfServiceProviderBooking($query,$service_provider_id,$today=null,$status=null)
    {
      $query->where('draft',false); 
      if($today)
      {
         if($status){
            return $query->orderBy('service_date','DESC')->orderBy('created_at','DESC')->where('service_provider_id',$service_provider_id)->whereDate('service_date',Carbon::today())->where('status',$status);
         }else{
          return $query->whereDate('service_date',Carbon::today())->where('service_provider_id',$service_provider_id)->orderBy('service_date','DESC')->orderBy('created_at','DESC');
         }
      }else{
          if($status){
            return $query->where('service_provider_id',$service_provider_id)->orderBy('service_date','DESC')->orderBy('created_at','DESC')->where('status',$status);
         }else{
           return $query->where('service_provider_id',$service_provider_id)->orderBy('service_date','DESC')->orderBy('created_at','DESC');
         }
      }
    }
    

    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function serviceProvider()
    {
      return $this->belongsTo(ServiceProvider::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
