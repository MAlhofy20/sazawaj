<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\user_imagesResource;
use App\Http\Resources\user_addressResource;
use App\Http\Resources\user_not_now_offersResource;
use App\Models\Section;
use App\Models\Country;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Order;
use App\Models\Device;
use App;

class userResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        $country = Country::whereId($this->country_id)->first();
        $city    = City::whereId($this->city_id)->first();
        //$neighborhood   = Neighborhood::whereId($this->neighborhood_id)->first();
        $device  = Device::where('user_id', $this->id)->where('device_id', $request->device_id)->first();

        if (App::getLocale() == 'en') {
            $gender  = ["male" => "male", "female" => "female"];
        } else {
            $gender  = ["male" => "ذكر", "female" => "انثى"];
        }

        if (App::getLocale() == 'en') {
            $expert  = ["junior" => "junior", "medium" => "medium", "professional" => "professional", "مبتدئ" => "junior", "متوسط" => "medium", "خبير" => "professional"];
        } else {
            $expert  = ["junior" => "مبتدئ", "medium" => "متوسط", "professional" => "خبير", "مبتدئ" => "مبتدئ", "متوسط" => "متوسط", "خبير" => "خبير"];
        }

        return [
            'id'                 => (int)    $this->id,
            'user_type'          => (string) $this->user_type,
            'first_name'         => (string) $this->first_name,
            // 'last_name'          => (string) $this->last_name,
            'email'              => (string) $this->email,
            'phone_code'         => (string) $this->phone_code,
            'phone'              => (string) $this->phone,
            'full_phone'         => (string) $this->full_phone,
            'api_token'          => (string) $this->api_token,
            // 'address'            => (string) $this->address,
            'gender'             => (string) $this->gender,
            'gender_f'           => isset($gender[$this->gender]) ? (string) $gender[$this->gender] : '',
            'expert'             => (string) $this->expert,
            'expert_f'           => isset($expert[$this->expert]) ? (string) $expert[$this->expert] : '',
            'lat'                => (float)  $this->lat,
            'lng'                => (float)  $this->lng,
            'country_id'         => (int)    $this->country_id,
            'country_title'      => isset($country) ? (string) $country->title : '',
            'city_id'            => (int)    $this->city_id,
            'city_title'         => isset($city) ? (string) $city->title : '',
            // 'neighborhood_id'    => (int)    $this->neighborhood_id,
            // 'neighborhood_title' => isset($neighborhood) ? (string) $neighborhood->title_ar : '',
            'is_active'          => $this->active == 1  ? true : false,
            'is_login'           => isset($device) ? true : false,
            'is_blocked'         => $this->blocked == 1 ? true : false,
            'is_confirmed'       => $this->confirm == 1 ? true : false,
            'lang'               => !is_null($this->lang)   ? (string) $this->lang : 'ar',
            'avatar'             => !is_null($this->avatar) ? url('' . $this->avatar) : url(''.settings('logo')),
            'devices'            => deviceResource::collection($this->devices),
        ];
    }
}
