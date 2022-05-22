<?php

namespace App\Http\Resources;

use App\Services\GeneralServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WithdrawResourceCollection extends ResourceCollection
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
         return [
             'data'=>$this->collection,
             'total_withdraw' => (new GeneralServices)->totalWithdraw($serviceProvider)
         ];
        // return parent::toArray($request);
    }
}
