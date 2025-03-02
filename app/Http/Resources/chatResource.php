<?php

namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App;

class chatResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        $lang     = App::getLocale() == 'en' ? 'en' : 'ar';
        Carbon::setLocale($lang);
        return [
            'id'                 => (int)    $this->id,
            'message'            => $this->type != 'image' ? (string)  $this->message : url('' . $this->message),
            'type'               => (string) $this->type,

            'to_id'              => (int)    $this->to_id,
            'from_id'            => (int)    $this->from_id,
            'from_name'          => (string) $this->From->name,
            'from_phone'         => (string) $this->From->phone,
            'duration'           => (string) Carbon::parse($this->created_at)->diffForHumans(),
            'date'               => date('Y-m-d', strtotime($this->created_at)),
        ];
    }
}
