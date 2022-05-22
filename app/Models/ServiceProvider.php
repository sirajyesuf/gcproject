<?php

namespace App\Models;

use App\Models\User\RateAndReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class ServiceProvider extends Authenticatable
{
    use HasFactory,HasApiTokens;
    protected $table = 'service_providers';
    protected $guarded = [];

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
}
