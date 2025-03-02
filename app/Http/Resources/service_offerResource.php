<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class service_offerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'amount'             => (float)  $this->amount,
            'price'              => (float)  $this->price,
        ];
    }
}
