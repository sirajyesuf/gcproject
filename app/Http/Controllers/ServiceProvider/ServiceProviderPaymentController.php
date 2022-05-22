<?php

namespace App\Http\Controllers\ServiceProvider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ServiceProvider\AddPaymentMethodRequest;
use App\Models\ProviderPaymentMethod;
use Illuminate\Http\Response;

class ServiceProviderPaymentController extends Controller
{

    private $serviceProvider;
    public function __construct()
    {
        $this->serviceProvider = Auth::guard('service_provider')->user();
    }
    public function addPaymentMethod(AddPaymentMethodRequest $addPaymentMethodRequest)
    {
       $inputs = $addPaymentMethodRequest->only(['payment_method','account_number','account_holder']);
       if($this->serviceProvider->paymentMethod){
           return response()->json(['status'=>'failed','you cant create agin'],202);
       }
       $payment = $this->serviceProvider->paymentMethod()->create($inputs);  
       return response()->json($payment,Response::HTTP_CREATED);      
    }

    public function editPaymentMethod(AddPaymentMethodRequest $addPaymentMethodRequest,$id)
    {
        $inputs = $addPaymentMethodRequest->only(['payment_method','account_number','account_holder']);
        $payment = ProviderPaymentMethod::findOrFail($id);
        $payment->update($inputs);  
        $payment->refresh();
        return response()->json($payment,Response::HTTP_OK);      
    }

    public function getPaymentMethod()
    {
        $payment = $this->serviceProvider->paymentMethod;
        return response()->json($payment,Response::HTTP_OK);
    }
}
