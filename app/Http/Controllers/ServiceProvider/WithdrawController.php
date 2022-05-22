<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\WithDrawRequest;
use App\Http\Resources\WithdrawResourceCollection;

class WithdrawController extends Controller
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
    
    public function askWithDraw(WithDrawRequest $withDrawRequest)
     {
         $checkPendingExistence = $this->serviceProvider->withdraws()->where('status',1)->exists();
        if($checkPendingExistence){
            return response()->json(['status'=>'fail','message'=>'you have already pending request'],Response::HTTP_ACCEPTED);
        }
        $inputs = $withDrawRequest->all();
        $inputs['status'] = 1;
        $withdraw = $this->serviceProvider->withdraws()->create($inputs);
        return response()->json($withdraw,Response::HTTP_CREATED);
     }

     public function withdraws()
     {
        $withdraws = $this->serviceProvider->withdraws()->paginate(15); 
        $withdraws = (new WithdrawResourceCollection($withdraws));
        return response()->json($withdraws->response()->getData(),Response::HTTP_OK);
     }

     public function withdraw($withdraw_id)
     {
        $withdraw = Withdraw::findOrFail($withdraw_id);
        return $withdraw;
     }
}
