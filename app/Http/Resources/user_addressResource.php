<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class user_addressResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'        => (int)    $this->id,
            'title'     => (string) $this->title,
            'address'   => (string) $this->address,
            'lat'       => (float)  $this->lat,
            'lng'       => (float)  $this->lng,
        ];
    }
}
