<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory,Uuids;
    
    protected $guarded = [];
    

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
