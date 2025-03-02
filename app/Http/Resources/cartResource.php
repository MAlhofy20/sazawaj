<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class cartResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);

        if(!is_null($this->service)) {
            $value_added         = (float) settings('value_added');
            //$total_without_value = ($this->total / (1 + $value_added) * $value_added);
            //$total_without_value = ($this->total - ($this->total / (1 + $value_added) * $value_added));
            return [
                'id'                       => (int)    $this->id,
                'count'                    => (float)  $this->count,
                'total'                    => $this->sub_total,
                'total_with_value'         => $this->total,
                'section_id'               => (int)    $this->section_id,
                'section_title'            => isset($this->section) ? (string) $this->section->title : '',
                'service_id'               => (int)    $this->service_id,
                'service_title'            => (string) $this->service->title,
                'service_price'            => $this->sub_total / $this->count,
                'service_price_with_value' => $this->total / $this->count,
                'service_image'            => !is_null($this->service) && $this->service->images->count() > 0 ? url('' . $this->service->images->first()->image) : url('public/none.png'),
                'notes'                    => (string) $this->notes,
                'option_id'                => (int)    $this->option_id,
                'option_title'             => (string) $this->option_title,
                'option_price'             => (float)  $this->option_price,
            ];
        }
    }
}
