<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\user_addressResource;
use App\Http\Resources\sub_sectionResource;
use App\Models\City;
use App\Models\Country;
use App\Models\Section;

class providerFullResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        $section = Section::whereId($this->section_id)->first();
        $country = Country::whereId($this->country_id)->first();
        $city    = City::whereId($this->city_id)->first();
        return [
            'id'               => (int)    $this->id,
            'name'             => empty($this->full_name) ? (string) $this->first_name : (string) $this->full_name,
            'email'            => (string) $this->email,
            'phone'            => (string) $this->full_phone,
            'section'          => (string) $section->title_ar,
            'country'          => (string) $country->title_ar,
            'city'             => (string) $city->title_ar,
            'address'          => (string) $this->address,
            'lat'              => (float)  $this->lat,
            'lng'              => (float)  $this->lng,
            'distance'         => (float) round($this->distance, 2),
            'has_delivery'     => (bool)   $this->has_delivery,
            'delivery'         => (float)  $this->delivery,
            'delivery_time'    => (float)  $this->delivery_time,
            'cash'             => (bool)   $this->cash,
            'transfer'         => (bool)   $this->transfer,
            'online'           => (bool)   $this->online,
            'not_now'          => (bool)   get_not_allow($this->id, $request->user_id)['status'],
            'not_now_total'    => (float)  get_not_allow($this->id, $request->user_id)['total'],
            'not_now_duration' => (float)  get_not_allow($this->id, $request->user_id)['duration'],
            'avatar'           => !is_null($this->avatar) ? url('' . $this->avatar) : url(''.settings('logo')),
            'sub_sections'     => sub_sectionResource::collection($this->sub_sections),
            'addresses'        => user_addressResource::collection($this->addresses),
        ];
    }
}
