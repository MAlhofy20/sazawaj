<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App;

class order_itemResource extends JsonResource
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
        $service_title = App::getLocale() == 'en' ? 'service_title_en' : 'service_title_ar';
        $total_with_value    = (float)  $this->total + ((float)  $this->total * $this->value_added  / 100);
        $total_without_value = round($this->total - $this->value_added, 2);
        return [
            'id'                => (int)    $this->id,
            'service_id'        => (int)    $this->service_id,
            'service_title'     => (string) $this->$service_title,
            'service_price'     => round($this->total / $this->count, 2),
            'service_image'     => !is_null($this->service) && $this->service->images->count() > 0 ? url('' . $this->service->images->first()->image) : url('public/none.png'),
            'count'             => (int)    $this->count,
            'total'             => round($total_without_value, 2),
            'value_added'       => round($this->value_added, 2),
            'total_with_value'  => round($this->total, 2),
            'notes'             => (string) $this->notes,
            'option_id'         => (int)    $this->option_id,
            'option_title'      => (string) $this->option_title,
            'option_price'      => (float)  $this->option_price,
        ];
    }
}
