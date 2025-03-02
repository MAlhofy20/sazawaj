<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\imageResource;
use App\Http\Resources\service_offerResource;

class serviceResource extends JsonResource
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
        $value_added      = (float)  $this->value_added;
        //$total_with_value = (float)  $this->price + ((float)  $this->price * $value_added / 100);
        $total_with_value = (float)  $this->price_with_value;
        return [
            'id'            => (int)    $this->id,
            'title'         => (string) $this->title,
            'desc'          => (string) $this->desc,
            'checked'       => (int) $request->service_id == (int) $this->id,
            // 'desc'          => (string) $this->desc,
            'distance'      => (float) get_distance($request->lat, $request->lng, $this->lat, $this->lng),
            'price_befor_discount' => (float)  $this->discount,
            'price'         => round((float)  $this->price, 2),
            'price_with_value' => $total_with_value,
            'value_added'   => (float)  $this->value_added,
            'rate'          => (float)  $this->rate,
            'is_favourite'  => (bool)   user_favourite($request->user_id, $this->id),
            'section_id'    => (int)    $this->section_id,
            'section_title' => is_null($this->section) ? '' : (string)  $this->section->title,
            'section_type'  => is_null($this->section) ? '' : (string)  $this->section->type,
            'sub_section_id'    => (int)    $this->sub_section_id,
            'sub_section_title' => is_null($this->sub_section) ? '' : (string)  $this->sub_section->title,
            'first_image'   => $this->images->count() > 0 ? url('' . $this->images->first()->image) : url(''.settings('logo')),
            'images'        => imageResource::collection($this->images),
            'options'       => service_optionResource::collection($this->options),
            'rates'         => rateResource::collection($this->rates),
            'times'         => show_times(),
        ];
    }
}
