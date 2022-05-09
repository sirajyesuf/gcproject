<?php

namespace App\Models;

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
}
