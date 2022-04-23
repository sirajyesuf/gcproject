<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Models\SmsCode;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Models\ServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ServiceProvider\RegistrationRequest;

class AuthenticationController extends Controller
{
    public function checkPhoneNumberExistence(Request $request)
    {   
        $rules = [
            'phone_number' => ['required',new PhoneNumber],
        ];
        $messages = [
            'phone_number.required' => 'please insert your phone number',
        ];
        
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $existence = ServiceProvider::where('phone_number', $request->phone_number)->exists();
        if ($existence) {
            return response()->json([
                'is_exist' => true
            ], 200);
        }

        return response()->json([
            'is_exist' => false
        ], 200);
    }

    public function register(RegistrationRequest $registrationRequest)
    {
      $extension = $registrationRequest->file('logo')->getClientOriginalExtension();
      $name = $registrationRequest->file('logo')->getClientOriginalName();
      $file_name = time().$name;
      $registrationRequest->file('logo')->move(public_path('provider_images'),$file_name);
      
      $provider = ServiceProvider::create([
        'phone_number'=>$registrationRequest->phone_number,
        'owner_name'=>$registrationRequest->owner_name,
        'business_name' => $registrationRequest->business_name,
        'latitude' =>$registrationRequest->latitude,
        'longitude'=>$registrationRequest->longitude,
        'logo'=>'provider_images/'.$file_name,
        'type'=>$registrationRequest->type
    ]);
      $send_sms = $this->sendSms($provider); 
      if($provider){
          return response()->json([
              'status'=>'success',
          ],Response::HTTP_CREATED);
      }
    }

    public function sendSms($provider)
    {
        $url = 'https://sms.hahucloud.com/api/send';
        $code = $this->smsCode($provider);
        $parametres = [
            'key'     => '9eb2f7e2bfe6b1e496578f32c0b1e311d58b67c1',
            'phone'   => $provider->phone_number,
            'message' => 'Your verification number is '.$code,
        ];
        $send_sms = Http::get($url,$parametres);
        if($send_sms->status() == 200){
            return true;
        }
        return false;
    }

    public function smsCode($provider)
    {
       $sms = SmsCode::where('service_provider_id',$provider->id)->first();
       $code = random_int(100000,999000);

       if($sms){
           $day = Carbon::create($sms->updated_at);
           $now = Carbon::now();
           if($day->diffInDays($now) < 1){
             if(!$sms->status){
                 return $sms->code;
             }
             SmsCode::where('service_provider_id',$provider->id)->update(['code'=>$code,'status'=>false]);
             return $code;
           }else{
               SmsCode::where('service_provider_id',$provider->id)->update(['code'=>$code,'status'=>false]);
               return $code;
           }
       }
       SmsCode::create([
           'code'    => $code,
           'service_provider_id' => $provider->id,
           'status'  => false
       ]);

       return $code;
    }

    public function login(Request $request)
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
        $provider = ServiceProvider::where('phone_number',$request->phone_number)->first();
        if($provider){
            $code = SmsCode::where('service_provider_id',$provider->id)->where('code',$request->code)->where('status',false)->first();
            if($code){
                $day = Carbon::create($code->updated_at);
                $now = Carbon::now();
                if($day->diffInDays($now) < 1){
                    SmsCode::where('service_provider_id',$provider->id)
                    ->where('code',$request->code)
                    ->where('status',false)
                    ->update(['status'=>true]);
                    $token = $provider->createToken($request->device_name)->plainTextToken;
                    return response()->json([
                        'status'=>'success',
                        'user'=>$provider,
                        'token'=>$token
                    ],200);
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
        $provider = ServiceProvider::where('phone_number',$request->phone_number)->first();
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $send_sms = $this->sendSms($provider);
        return response()->json([
            'sent'=>'message sent',
            'status'=>'success',
        ],200);  

    }
}
