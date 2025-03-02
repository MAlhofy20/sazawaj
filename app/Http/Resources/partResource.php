<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\serviceResource;
use App\Models\Service;

class partResource extends JsonResource
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
        $page          = (int) $request->page_id > 0 ? new serviceResource(Service::whereId((int) $request->page_id)->first()) : [];
        $first_page    = $this->services->count() > 0 ? new serviceResource($this->services->first()) : [];
        $first_page_id = $this->services->count() > 0 ? $this->services->first()->id : 0;
        return [
            'id'         => (int)    $this->id,
            'title'      => (string) $this->title,
            'image'      => !is_null($this->image) ? url('' . $this->image) : url('public/none.png'),
            'pages_count'   => $this->services->count(),
            'pages_id'   => $this->services->pluck('id')->toArray(),
            'previous'   => previous_page($this->id , (int) $request->page_id),
            'next'       => next_page($this->id , (int) $request->page_id),
            'page'       => !empty($page) ? $page : $first_page,
        ];
    }
}
