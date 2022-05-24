<?php

namespace App\Http\Resources;

use App\Services\GeneralServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookingResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $serviceProvider = Auth::guard('service_provider')->user();
        $total_earning = (new GeneralServices)->serviceProviderTotalEarning($serviceProvider);
        $total_service_fee = (new GeneralServices)->serviceProviderTotalFee($serviceProvider);
        $total_balance = (new GeneralServices)->serviceProviderTotalBalance($serviceProvider);
         return [
             'data'=>$this->collection,
             'total_earning'=>$this->when($request->is('user/*'),$total_earning),
             'total_service_fee'=>$this->when($request->is('user/*'),$total_service_fee),
             'total_balance'=>$this->when($request->is('user/*'),$total_balance),
         ];
    }
}
