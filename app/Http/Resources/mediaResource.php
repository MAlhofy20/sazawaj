<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class mediaResource extends JsonResource
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
            'id'            => (int)    $this->id,
            'title'         => (string) $this->title,
            'short_desc'    => (string) $this->short_desc,
            'desc'          => (string) $this->desc,
            'date'          => (string) $this->date,
            'lat'           => (float)  $this->lat,
            'lng'           => (float)  $this->lng,
            'distance'      => (float) get_distance($request->lat, $request->lng, $this->lat, $this->lng),
            'image'         => !is_null($this->image) ? url('' . $this->image) : url('public/none.png'),
            'video'         => !is_null($this->video) ? url('' . $this->video) : '',
        ];
    }
}
