<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class deviceResource extends JsonResource
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
            'device_id' => (string) $this->device_id,
            'is_login'  => (bool) $this->login,
        ];
    }
}
