<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Featured extends Model
{
    use HasFactory;
    protected $table = 'featureds';

    protected $guarded = [];

    public function service_provider(){

        return $this->belongsTo(ServiceProvider::class);

    }

}
