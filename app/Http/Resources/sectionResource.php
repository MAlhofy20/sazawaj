<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\sub_sectionResource;
use App\Models\Service;

class sectionResource extends JsonResource
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
        $service = Service::whereId($request->service_id)->first();
        return [
            'id'            => (int)    $this->id,
            'title'         => (string) $this->title,
            'type'          => (string) $this->type,
            'checked'       => isset($service) ? (int) $service->section_id == (int) $this->id : (int) $request->section_id == (int) $this->id,
            // 'desc'          => (string) $this->desc,
            'image'         => !is_null($this->image) ? url('' . $this->image) : url(''.settings('logo')),
            // 'sub_sections'  => sub_sectionResource::collection($this->sub_sections),
        ];
    }
}
