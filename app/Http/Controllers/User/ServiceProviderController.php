<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceProviderResource;

class ServiceProviderController extends Controller
{
     public function listOfServiceProviders($latitude,$longitude)
     {
        $latitude = $latitude;
        $longitude = $longitude;

        $serviceProviders = ServiceProvider::select("id","business_name","phone_number","owner_name","latitude","longitude","logo","type", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
             * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
             + sin(radians(" .$latitude. ")) * sin(radians(latitude))) AS distance"))
             ->having('distance', '<', 1000)
             ->orderBy('distance','ASC')
             ->paginate(10);
        return ServiceProviderResource::collection($serviceProviders);     
     }

     
}
