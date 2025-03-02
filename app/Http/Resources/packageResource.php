<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class packageResource extends JsonResource
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
            'id'           => (int)    $this->id,
            'title'        => (string) $this->title,
            'desc'         => (string) $this->desc,
            'amount'       => (int)    $this->amount,
            'price'        => (float)  $this->price,
            'image'        => !is_null($this->image) ? url('' . $this->image) : url(''.settings('logo')),
            'user_id'      => (int)    $this->user_id,
            'user_name'    => !is_null($this->user) ? $this->user->full_name : '',
            'cash'         => !is_null($this->user) ? (bool)   $this->user->cash : false,
            // 'transfer'     => !is_null($this->user) ? (bool)   $this->user->transfer : false,
            'online'       => !is_null($this->user) ? (bool)   $this->user->online : false,
            'user_address' => !is_null($this->user) ? $this->user->address : '',
            'lat'          => is_null($this->user) ? 0 : (float) $this->user->lat,
            'lng'          => is_null($this->user) ? 0 : (float) $this->user->lng,
            'distance'     => is_null($this->user) ? 0 : (float) get_distance($request->lat, $request->lng, $this->user->lat, $this->user->lng),
            'day'          => empty($this->date) ? '' : day_to_arabic(Carbon::parse($this->date)->format('l')),
            'date'         => (string) $this->date,
            'start_time'   => (string) $this->start_time,
            'start_time_f' => empty($this->start_time) ? '' : Carbon::parse($this->start_time)->format('h:i a'),
            'end_time'     => (string) $this->end_time,
            'end_time_f'   => empty($this->end_time) ? '' : Carbon::parse($this->end_time)->format('h:i a'),
        ];
    }
}
