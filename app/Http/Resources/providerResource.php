<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\user_addressResource;
use App\Http\Resources\sub_sectionResource;
use App\Models\Section;
use App\Models\Country;
use App\Models\City;
use App\Models\Neighborhood;

class providerResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        $section = Section::whereId($this->section_id)->first();
        $city = City::whereId($this->city_id)->first();
        return [
            'id'                 => (int)    $this->id,
            'type'               => (string) $this->user_type,
            'first_name'         => (string) $this->full_name,
            // 'last_name'          => (string) $this->last_name,
            'email'              => (string) $this->email,
            'full_phone'         => (string) $this->full_phone,
            'phone'              => (string) $this->phone,
            // 'phone_code'         => (string) $this->phone_code,
            'desc'               => (string) $this->desc,
            'whatsapp'           => (string) $this->whatsapp,
            'whatsapp'           => (string) $this->whatsapp,
            'twitter'            => (string) $this->twitter,
            'instagram'          => (string) $this->instagram,
            'snapchat'           => (string) $this->snapchat,
            'section_id'         => (int)    $this->section_id,
            'section_title'      => isset($section) ? (string) $section->title : '',
            'city_id'            => (int)    $this->city_id,
            'city_title'         => isset($city) ? (string) $city->title : '',
            'address'            => (string) $this->address,
            'cash'               => (bool)   $this->cash,
            // 'transfer'           => (bool)   $this->transfer,
            'online'             => (bool)   $this->online,
            'price'              => $this->offers->count() > 0 ? $this->offers->first()->price : (float) $this->price,
            'lat'                => (float) $this->lat,
            'lng'                => (float) $this->lng,
            'distance'           => (float) get_distance($request->lat, $request->lng, $this->lat, $this->lng),
            'avatar'             => !is_null($this->avatar) ? url('' . $this->avatar) : url('public/user.png'),
            //'license_image'      => !is_null($this->license_image) ? url('' . $this->license_image) : url('public/user.png'),
            // 'license_image'      => $this->images->count() > 0 ? url('' . $this->images->first()->image) : url(''.settings('logo')),
            'images'             => user_imagesResource::collection($this->images),
            'prices'             => user_pricesResource::collection($this->offers),
            'packages'           => packageResource::collection($this->packages),
        ];
    }
}
