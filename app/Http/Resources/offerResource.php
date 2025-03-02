<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class offerResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        $name = '';
        if (!is_null($this->user)) $name = empty($this->user->full_name) ? (string) $this->user->name : (string) $this->user->full_name;
        $avatar = url('public/user.png');
        if (!is_null($this->user)) $avatar = !is_null($this->user->avatar) ? url('' . $this->user->avatar) : url('public/user.png');

        return [
            'id'       => (int)    $this->id,
            'user_id'  => (int)    $this->user_id,
            'name'     => $name,
            'desc'     => (string) $this->desc,
            'price'    => (float)  $this->price,
            'delivery' => !is_null($this->user) ? (float)  $this->user->delivery : 0,
            'avatar'   => $avatar,
        ];
    }
}
