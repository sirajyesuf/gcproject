<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\User\RateAndReview;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_number',
    ];

    public function canAccessFilament(): bool
    {
        return true;
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function rateAndReviews()
    {
        return $this->hasMany(RateAndReview::class);
    }

    public function getProfilePictureAttribute($value)
    {
        if(empty($value)){
            return url('user_images/profile_picture.png');
        }
        return url($value);
    }
}
