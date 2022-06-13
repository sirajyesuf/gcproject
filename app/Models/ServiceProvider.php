<?php

namespace App\Models;

use App\Models\User\RateAndReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Http;


class ServiceProvider extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table = 'service_providers';
    protected $guarded = [];


    // protected function Latitude(): Attribute
    // {


    //     return Attribute::make(
    //         get: fn ($value, $attributes) => $this->getAddress($value, $attributes['longitude'])
    //     );
    // }



    // protected function getAddress($lat, $long)
    // {


    //     $query_string = [
    //         'access_key' => env('POSITION_STACK_API_TOKEN', 'c14eb56c68396e19d6b7439d83747b80'),
    //         'query' => "$lat,$long",
    //         'output' => 'json'
    //     ];


    //     $response = Http::get(env('POSITION_STACK_API_BASE_URL', "https://api.positionstack.com/v1/reverse"), $query_string);

    //     // dd($response);
    // }
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(RateAndReview::class);
    }

    public function paymentMethod()
    {
        return $this->hasOne(ProviderPaymentMethod::class);
    }

    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }
    public function featured()
    {
        return $this->hasOne(Featured::class);
    }
}
