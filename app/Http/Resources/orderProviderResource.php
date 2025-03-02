<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\order_itemResource;
use App;

class orderProviderResource extends JsonResource
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
        $payment  = ["cash" => "كاش", "transfer" => "تحويل بنكي", "online" => "اون لاين" , "not_now" => "الدفع اجلا"];
        return [
            'id'                => (int) $this->order_id,
            'user_id'           => is_null($this->order) ? 0  : (int)    $this->order->user_id,
            'user_name'         => is_null($this->order) ? '' : (string) $this->order->user_name,
            'user_phone'        => is_null($this->order) ? '' : (string) $this->order->user_phone,
            'user_lat'          => is_null($this->order) ? '' : (float)  $this->order->lat,
            'user_lng'          => is_null($this->order) ? '' : (float)  $this->order->lng,
            'user_address'      => is_null($this->order) ? '' : (string) $this->order->address,

            'provider_id'       => is_null($this->order) ? 0  : (int)    $this->order->provider_id,
            'provider_debt'     => is_null($this->order) ? 0  : (float)  $this->order->provider_debt,
            'provider_name'     => is_null($this->order) ? '' : (string) $this->order->provider_name,
            'provider_phone'    => is_null($this->order) ? '' : (string) $this->order->provider_phone,
            'provider_lat'      => is_null($this->order) ? '' : (float)  $this->order->provider_lat,
            'provider_lng'      => is_null($this->order) ? '' : (float)  $this->order->provider_lng,

            'delegate_id'       => is_null($this->order) ? 0  : (int)    $this->order->delegate_id,
            'delgate_debt'      => is_null($this->order) ? 0  : (float)  $this->order->delgate_debt,
            'delegate_name'     => !is_null($this->order) && !is_null($this->order->delegate) ? (string) $this->order->delegate->name : '',
            'delegate_phone'    => !is_null($this->order) && !is_null($this->order->delegate) ? (string) $this->order->delegate->phone : '',
            'delegate_lat'      => !is_null($this->order) && !is_null($this->order->delegate) ? (float)  $this->order->delegate->lat : '',
            'delegate_lng'      => !is_null($this->order) && !is_null($this->order->delegate) ? (float)  $this->order->delegate->lng : '',

            'status_map'        => get_status_map($this->order->status),
            'status'            => is_null($this->order) ? '' : (string) $this->order->status,
            'status_f'          => is_null($this->order) ? '' : order_status($this->order->status),
            'payment_method'    => is_null($this->order) ? '' : (string) $this->order->payment_method,
            'payment_method_f'  => !is_null($this->order) && isset($payment[$this->order->payment_method]) ? $payment[$this->order->payment_method] : 'كاش',
            'sub_total'         => is_null($this->order) ? 0  : (float)  $this->order->sub_total,
            'delivery'          => is_null($this->order) ? 0  : (float)  $this->order->delivery,
            'value_added'       => is_null($this->order) ? 0  : (float)  $this->order->value_added,
            'otal_before_promo' => is_null($this->order) ? 0  : (float)  $this->order->total_before_promo,
            'total_after_promo' => is_null($this->order) ? 0  : (float)  $this->order->total_after_promo,
            'duration'          => is_null($this->order) ? '' : (string) $this->order->duration,

            'order_services'    => order_itemResource::collection($this->order->order_items)
        ];
    }
}
