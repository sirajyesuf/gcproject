<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function provider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}
