<?php

namespace App\Models;

use App\Services\GeneralServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Featured extends Model
{
    use HasFactory;
    protected $table = 'featureds';

    protected $guarded = [];
    protected $appends = ['rate'];

    public function service_provider()
    {

        return $this->belongsTo(ServiceProvider::class);

    }

    public function getImagePathAttribute($value)
    {
       if(!request()->is('admin')){
        return url('/storage/'.$value);
       }
    }

    public function getRateAttribute()
    {
        $service  =  new GeneralServices();
        $rate     =  $service->calculateAverageRate($this->service_provider_id);
        return $rate;
    }

}
