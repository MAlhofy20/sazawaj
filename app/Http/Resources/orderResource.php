<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\order_itemResource;
use App\Http\Resources\order_offerResource;
use App\Models\Order_provider;
use App\Models\Order;
use App\Models\Country;
use App\Models\City;
use Carbon\Carbon;
use App;

class orderResource extends JsonResource
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
        if (App::getLocale() == 'en'){
            $payment  = ["cash" => "cash", "transfer" => "bank transfer", "online" => "online"];
            $gender  = ["male" => "male", "female" => "female"];
            $expert  = ["junior" => "junior", "medium" => "medium", "professional" => "professional"];
        } else {
            $payment  = ["cash" => "كاش", "transfer" => "تحويل بنكي", "online" => "اون لاين"];
            $gender  = ["male" => "ذكر", "female" => "انثى"];
            $expert  = ["junior" => "مبتدئ", "medium" => "متوسط", "professional" => "خبير"];
        }

        return [
            'id'                 => (int) $this->id,
            'user_id'            => (int)    $this->user_id,
            'user_name'          => !is_null($this->user) ? (string) $this->user->name : (string)  $this->user_name,
            'user_phone'         => !is_null($this->user) ? (string) $this->user->phone : (string)  $this->user_phone,
            'user_gender'        => !is_null($this->user) ? (string) $this->user->gender : '',
            'user_gender_f'      => !is_null($this->user) && isset($gender[$this->user->gender]) ? (string) $gender[$this->user->gender] : '',
            'user_expert'        => !is_null($this->user) ? (string) $this->user->expert : '',
            'user_expert_f'      => !is_null($this->user) && isset($expert[$this->user->expert]) ? (string) $expert[$this->user->expert] : '',

            'name'               => (string) $this->name,
            'amount'             => (string) $this->amount,
            'day'                => empty($this->date) ? '' : day_to_arabic(Carbon::parse($this->date)->format('l')),
            'date'               => (string) $this->date,
            'start_time'         => empty($this->time) ? '' : Carbon::parse($this->time)->format('H:i:a'),
            'start_time_f'       => empty($this->time) ? '' : Carbon::parse($this->time)->format('h:i a'),
            'end_time'           => empty($this->time) ? '' : Carbon::parse($this->time)->addMinutes((int) $this->amount)->format('H:i:a'),
            'end_time_f'         => empty($this->time) ? '' : Carbon::parse($this->time)->addMinutes((int) $this->amount)->format('h:i a'),

            'address'            => is_null($this->provider) ? '' : (string) $this->provider->address,
            'lat'                => is_null($this->provider) ? 0 : (float) $this->provider->lat,
            'lng'                => is_null($this->provider) ? 0 : (float) $this->provider->lng,
            'distance'           => is_null($this->provider) ? 0 : (float) get_distance($request->lat, $request->lng, $this->provider->lat, $this->provider->lng),

            // 'status_map'         => get_status_map($this->status),
            'status'             => (string) $this->status,
            'status_f'           => order_status($this->status),
            'payment_method'     => (string) $this->payment_method,
            'payment_method_f'   => isset($payment[$this->payment_method]) ? $payment[$this->payment_method] : $payment['cash'],
            // 'sub_total'          => round((float)  $this->sub_total, 2),
            //'delivery'           => round((float)  $this->delivery, 2),
            // 'value_added'        => round((float)  $this->value_added, 2),
            'total_before_promo' => round((float)  $this->total_before_promo, 2),
            'total_after_promo'  => round((float)  $this->total_after_promo, 2),
            // 'duration'           => (string) $this->duration,
            'is_paid'            => (bool)   $this->is_paid,
            'is_rated'           => (bool)   $this->is_rated,
            'rate'               => (int)    $this->rate,
            'desc'               => (string) $this->desc,
            'notes'              => (string) $this->notes,
            'order_date_time'    => date('Y-m-d h:i a' , strtotime($this->created_at)),
            'order_date'         => date('Y-m-d' , strtotime($this->created_at)),
            'order_time'         => date('h:i a' , strtotime($this->created_at))
        ];
    }
}
