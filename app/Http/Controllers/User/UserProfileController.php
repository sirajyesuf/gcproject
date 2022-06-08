<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditUserProfileRequest;
use App\Rules\PhoneNumber;
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

    public function editProfile(Request $request)
    {
        $userInput = [];
        if($request->filled('phone_number')){
            $rules = [
                'phone_number'=>['required',new PhoneNumber],
            ];
            if($request->phone_number != $this->user->phone_number){
                $rules = [
                    'phone_number'=>['unique:users,phone_number',new PhoneNumber],
                ];
                
            }
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                   throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY)); 
            }
            $userInput['phone_number'] = $request->phone_number;
        }
        if($request->filled('name')){
            $rules = [
                'name'=>['required'],
            ];
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                   throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY)); 
            }
            $userInput['name'] = $request->name;
        }
        if($request->hasFile('profile_picture')){
            $rules = [
                'profile_picture'=>['required','image',],
            ];
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                   throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY)); 
            }
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            $name = $request->file('profile_picture')->getClientOriginalName();
            $file_name = time().$name;
            $request->file('profile_picture')->move(public_path('user_images'),$file_name);
            $userInput['profile_picture'] = 'user_images'.'\/'.$file_name;
        }
         if(isset($userInput)){
            $this->user->update($userInput);
            $this->user->refresh();
            return response()->json($this->user,Response::HTTP_OK);
         }else{
             return response()->json(['status'=>'fail','message'=>'nothing update'],Response::HTTP_ACCEPTED);
         }
         
    }

    public function logOut()
    {
         $this->user->currentAccessToken()->delete();
         return response()->json(['status'=>'success'],200);
    }

   
}
