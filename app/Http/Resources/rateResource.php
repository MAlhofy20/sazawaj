<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class rateResource extends JsonResource
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
            'user_id'     => (int)    $this->user_id,
            'user_name'   => !is_null($this->user) ? $this->user->name : (string)  $this->user_name,
            'user_avatar' => !is_null($this->user) && !is_null($this->user->avatar) ? url('' . $this->user->avatar) : url('public/user.png'),
            'rate'        => (string) $this->rate,
            'desc'        => (string) $this->desc,
        ];
    }
}
