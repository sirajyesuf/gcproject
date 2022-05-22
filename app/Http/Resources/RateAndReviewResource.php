<?php

namespace App\Http\Resources;

use App\Services\GeneralServices;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RateAndReviewResource extends ResourceCollection
{
    private $service_provider_id;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->service_provider_id = $request->route('service_provider_id');
        $rate = (new GeneralServices)->calculateAverageRate($this->service_provider_id);
        return [
            'data'=>$this->collection,
            'rate'=>$rate
        ];
        // return parent::toArray($request);
    }

    
}
