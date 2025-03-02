<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class service_optionResource extends JsonResource
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
        $value_added      = (float)  $this->service->value_added;
        //$total_with_value = (float)  $this->price + ((float)  $this->price * $value_added / 100);
        $total_with_value = (float)  $this->price_with_value;

        return [
            'id'    => (int)    $this->id,
            'title' => (string) $this->title,
            'price' => round((float)  $this->price, 2),
            'price_with_value' => $total_with_value,
        ];
    }
}
