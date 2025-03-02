<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class user_not_now_offersResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        $total = $this->total - $this->current_total;
        return [
            //'id'            => (int)    $this->id,
            'saler_id'      => (int)    $this->saler_id,
            'saler_name'    => is_null($this->saler) ? '' : (string) $this->saler->first_name,
            'status'        => $total > 0 ? true : false,
            'all_total'     => $this->total,
            'used_total'    => $this->current_total,
            'total'         => $total > 0 ? $total : 0,
            'duration'      => $this->duration,

        ];
    }
}
