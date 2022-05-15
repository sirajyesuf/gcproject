<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function listOfServices($service_provider_id)
    {
       $services = Service::where('service_provider_id',$service_provider_id)->get();
       return response()->json(['services'=>$services],200);
    }


}
