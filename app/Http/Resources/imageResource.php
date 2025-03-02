<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class imageResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'    => (int)    $this->id,
            'image' => !is_null($this->image) ? url('' . $this->image) : url('public/user.png'),
        ];
    }
}
