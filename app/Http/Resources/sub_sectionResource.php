<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\serviceResource;
use App\Models\Service;

class sub_sectionResource extends JsonResource
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
            'image'         => !is_null($this->image) ? url('' . $this->image) : url('public/none.png'),
            'checked'       => isset($service) ? (int) $service->sub_section_id == (int) $this->id : (int) $request->sub_section_id == (int) $this->id,

            'section_id'    => (int)    $this->section_id,
            'section_title' => is_null($this->section) ? '' : (string) $this->section->title,
            'type'          => is_null($this->section) ? '' : (string) $this->section->type,
        ];
    }
}
