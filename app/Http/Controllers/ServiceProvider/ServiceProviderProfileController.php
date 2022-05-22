<?php

namespace App\Http\Controllers\ServiceProvider;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceProvider\EditProfileRequest;
use App\Http\Requests\ServiceProvider\EditServiceProviderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\ServiceProvider\RegistrationRequest;

class ServiceProviderProfileController extends Controller
{
    private $serviceProvider;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->serviceProvider = Auth::guard('service_provider')->user();
    } 

    public function profile()
    {
        $profile = Auth::guard('service_provider')->user();
        return response()->json($profile,200);
    }

    public function editProfile(EditProfileRequest $registrationRequest)
    {
         
         $inputs = $registrationRequest->all();
         if($registrationRequest->phone_number != $this->serviceProvider->phone_number){
             $rules = [
                 'phone_number'=>'unique:service_providers,phone_number',
             ];
             $validator = Validator::make($inputs,$rules);
             if($validator->fails()){
                throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY)); 
             }
         }
         $this->serviceProvider->update($inputs);
         $this->serviceProvider->refresh();
         return response()->json($this->serviceProvider,Response::HTTP_OK);
    }

    public function logOut()
    {
         $this->serviceProvider->currentAccessToken()->delete();
         return response()->json(['status'=>'success'],200);
    }
}
