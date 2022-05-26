<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditUserProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserProfileController extends Controller
{
    private $user;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::guard('user')->user();
    } 

    public function profile()
    {
        $profile = Auth::guard('user')->user();
        return response()->json($profile,200);
    }

    public function editProfile(EditUserProfileRequest $editUserProfileRequest)
    {
         
         $inputs = $editUserProfileRequest->all();
         if($editUserProfileRequest->phone_number != $this->user->phone_number){
             $rules = [
                 'phone_number'=>'unique:users,phone_number',
             ];
             $validator = Validator::make($inputs,$rules);
             if($validator->fails()){
                throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY)); 
             }
         }
         $this->user()->update($inputs);
         $this->user()->refresh();
         return response()->json($this->user,Response::HTTP_OK);
    }

    public function logOut()
    {
         $this->user->currentAccessToken()->delete();
         return response()->json(['status'=>'success'],200);
    }

   
}
