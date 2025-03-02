<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\imageResource;
use App\Http\Resources\service_offerResource;

class serviceFavouriteResource extends JsonResource
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
        if(is_null($this->service)) return [];
        $value_added      = (float)  $this->service->value_added;
        //$total_with_value = (float)  $this->service->price + ((float)  $this->service->price * $value_added / 100);
        $total_with_value = (float)  $this->service->price_with_value;
        return [
            'id'            => (int)    $this->service->id,
            'title'         => (string) $this->service->title,
            'desc'          => (string) $this->service->desc,
            'checked'       => (int) $request->service_id == (int) $this->service->id,
            // 'desc'          => (string) $this->service->desc,
            'price_befor_discount' => (float)  $this->service->discount,
            'price'         => round((float)  $this->service->price, 2),
            'price_with_value' => $total_with_value,
            'value_added'   => (float)  $this->service->value_added,
            'rate'          => (float)  $this->service->rate,
            'is_favourite'  => (bool)   user_favourite($request->user_id, $this->service->id),
            'section_id'    => (int)    $this->service->section_id,
            'section_title' => is_null($this->service->section) ? '' : (string)  $this->service->section->title,
            'first_image'   => $this->service->images->count() > 0 ? url('' . $this->service->images->first()->image) : url(''.settings('logo')),
        ];
    }
}
