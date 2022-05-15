<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DepositRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function deposit(DepositRequest $depositRequest)
    {
       $deposit = $depositRequest->all();
       $deposit['status'] = false; 
       $user = Auth::guard('user')->user();
       $deposit = $user->deposits()->create($deposit);
       return response()->json(['deposit'=>$deposit],Response::HTTP_CREATED);         
    }
}
