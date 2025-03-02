<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class notificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => (int)    $this->id,
            'message'           => (string) $this->message,
            'type'              => (string) $this->type,
            'order_id'          => (int)    $this->order_id,
            'order_status'      => (string) $this->order_status,
            'date'              => date('Y-m-d h:i a', strtotime($this->created_at)),
            'time'              => date('h:i a', strtotime($this->created_at)),
            'duration'          => $this->created_at->diffForHumans(),
        ];
    }
}
