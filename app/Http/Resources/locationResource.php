<?php

namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class locationResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'    => (int)    $this->id,
            'title' => (string) $this->title,
            'lat'   => (float)  $this->lat,
            'lng'   => (float)  $this->lng,
        ];
    }
}
