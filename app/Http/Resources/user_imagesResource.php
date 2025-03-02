<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class user_imagesResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'image' => !is_null($this->image) ? url('' . $this->image) : url('public/user.png'),
        ];
    }
}
