<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SmsCode;
use App\Rules\PhoneNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function checkPhoneNumberExistence(Request $request)
    {
        $existence = User::where('phone_number', $request->phone_number)->exists();
        if ($existence) {
            return response()->json([
                'is_exist' => true
            ], 200);
        }

        return response()->json([
            'is_exist' => false
        ], 200);
    }

    public function register(Request $request)
    {
        $rules = [
            'phone_number' => ['required','unique:users,phone_number',new PhoneNumber],
            'name' => 'required'
        ];
        $messages = [
            'phone_number.required' => 'please insert your phone number',
            'phone_number.unique'   => 'phone already exist',
            'name.required'         => 'please insert your fullname'
        ];
        
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $user = User::create([
            'name'         => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        $send_sms = $this->sendSms($user);
        return response()->json([
            'sent'=>'message sent',
            'status'=>'success',
        ],200);       
    }
    
    public function sendSms($user)
    {
        $url = 'https://sms.hahucloud.com/api/send';
        $code = $this->smsCode($user);
        $parametres = [
            'key'     => '9eb2f7e2bfe6b1e496578f32c0b1e311d58b67c1',
            'phone'   => $user->phone_number,
            'message' => 'Your verification number is '.$code,
        ];
        $send_sms = Http::get($url,$parametres);
        if($send_sms->status() == 200){
            return true;
        }
        return false;
    }

    public function smsCode($user)
    {
       $sms = SmsCode::where('user_id',$user->id)->first();
       $code = random_int(100000,999000);

       if($sms){
           $day = Carbon::create($sms->updated_at);
           $now = Carbon::now();
           if($day->diffInDays($now) < 1){
             if(!$sms->status){
                 return $sms->code;
             }
             SmsCode::where('user_id',$user->id)->update(['code'=>$code,'status'=>false]);
             return $code;
           }else{
               SmsCode::where('user_id',$user->id)->update(['code'=>$code,'status'=>false]);
               return $code;
           }
       }
       SmsCode::create([
           'code'    => $code,
           'user_id' => $user->id,
           'status'  => false
       ]);

       return $code;
    }

    public function verify(Request $request)
    {
        $rules = [
            'phone_number' => ['required',new PhoneNumber],
            'code' => 'required',
            'device_name'=>'required'
        ];
        $messages = [
            'phone_number.required' => 'please send  phone number',
            'code.required'         => 'please send your code',
            'device_name.required'  => 'device name is required',
        ];
        
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $user = User::where('phone_number',$request->phone_number)->first();
        if($user){
            $code = SmsCode::where('user_id',$user->id)->where('code',$request->code)->where('status',false)->first();
            if($code){
                $day = Carbon::create($code->updated_at);
                $now = Carbon::now();
                if($day->diffInDays($now) < 1){
                    SmsCode::where('user_id',$user->id)
                    ->where('code',$request->code)
                    ->where('status',false)
                    ->update(['status'=>true]);
                    $token = $user->createToken($request->device_name)->plainTextToken;
                    return response()->json([
                        'status'=>'success',
                        'user'=>$user,
                        'token'=>$token
                    ]);
                }
                return response()->json(['status'=>'fail','message'=>'invalid or expired code'],401);
            }
            return response()->json(['status'=>'fail','message'=>'invalid or expired code'],401);

        }
        return response()->json(['status'=>'fail','message'=>'phone number not found'],404);

    }

    public function resend(Request $request)
    {
        $rules = [
            'phone_number' => ['required',new PhoneNumber],
        ];
        $messages = [
            'phone_number.required' => 'please send  phone number',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        $user = User::where('phone_number',$request->phone_number)->first();
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $send_sms = $this->sendSms($user);
        return response()->json([
            'sent'=>'message sent',
            'status'=>'success',
        ],200);  

    }

    public function login(Request $request)
    {
        $rules = [
            'phone_number' => ['required',new PhoneNumber],
            'code'         => 'required',
            'device_name'  => 'required',
        ];
        $messages = [
            'phone_number.required' => 'please send  phone number',
            'code.required'         =>  'please send your code',
            'device_name.required'  =>  'device name is required'
        ]; 
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $user = User::where('phone_number',$request->phone_number)->first();
        if($this->checkCodeIsValid($user,$request->code,$request->device_name)){
            SmsCode::where('user_id',$user->id)
            ->where('code',$request->code)
            ->where('status',false)
            ->update(['status'=>true]);
            $token = $user->createToken($request->device_name)->plainTextToken;
            return response()->json([
                'status'=>'success',
                'user'=>$user,
                'token'=>$token
            ],200);
        }
        return response()->json(['status'=>'fail','message'=>'invalid credentials'],401);
    }

    public function checkCodeIsValid($user,$code,$device_name)
    {
        if($user){
            $code = SmsCode::where('user_id',$user->id)->where('code',$code)->where('status',false)->first();
            if($code){
                $day = Carbon::create($code->updated_at);
                $now = Carbon::now();
                if($day->diffInDays($now) < 1){
                   return true; 
                }
                return false;
            }
            return false;

        }
        return false;
    }
    
}
