<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\GeneralServices;

class ServiceProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'logo' => $this->logo,
            'type' => $this->type,
            'business_name' => $this->business_name,
            'owner_name' => $this->owner_name,
            'latitude' => $this->latitude,
            'longitude'=> $this->longitude,
            'logo' => $this->logo,
            'rate'=> 1,
            'distance'=>$this->distance,
            'rate'=> (new GeneralServices)->calculateAverageRate($this->id),
        ];
    }
}
