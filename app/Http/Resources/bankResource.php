<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class bankResource extends JsonResource
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
            'id'             => (int)    $this->id,
            'bank_name'      => (string) $this->title,
            //'account_name'   => (string) $this->account_name,
            'account_number' => (string) $this->account_number,
            'iban_number'    => (string) $this->iban_number,
            //'image'          => !is_null($this->image) ? url('' . $this->image) : url('public/none.png'),
        ];
    }
}
