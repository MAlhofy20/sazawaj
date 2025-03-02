<?php

namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class roomResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'            => (int)    $this->id,
            'other_id'      => $request->user_id == $this->user_id ? (int) $this->saler_id : (int) $this->user_id,
            'order_id'      => (int)    $this->order_id,
            'user_id'       => (int)    $this->user_id,
            'user_name'     => !is_null($this->user) ? (string) $this->user->name : '',
            'user_phone'    => !is_null($this->user) ? (string) $this->user->phone : '',
            'saler_id'      => (int)    $this->saler_id,
            'saler_name'    => !is_null($this->saler) ? (string) $this->saler->name : '',
            'saler_phone'   => !is_null($this->saler) ? (string) $this->saler->phone : '',

            'last_message'  => !is_null($this->chats_desc) ? last_room_chat($this->id)['last_message'] : '',
            'message_type'  => !is_null($this->chats_desc) ? last_room_chat($this->id)['type'] : '',
            'sender_id'     => !is_null($this->chats_desc) ? last_room_chat($this->id)['sender_id'] : '',
            'duration'      => !is_null($this->chats_desc) ? last_room_chat($this->id)['duration'] : '',
            'date'          => !is_null($this->chats_desc) ? last_room_chat($this->id)['date'] : '',
        ];
    }
}
