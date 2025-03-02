<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class user_pricesResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            //'id'            => (int)    $this->id,
            'amount' => (int) $this->amount,
            'price'  => (float) $this->price,

        ];
    }
}
