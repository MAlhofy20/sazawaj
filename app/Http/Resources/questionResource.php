<?php

namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App;

class questionResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'             => (int)    $this->id,
            'question'       => (string) $this->question_ar,
            'first_answer'   => (string) $this->first_answer_ar,
            'second_answer'  => (string) $this->second_answer_ar,
            'third_answer'   => (string) $this->third_answer_ar,
            'fourth_answer'  => (string) $this->fourth_answer_ar,
            'answer'         => (string) $this->answer,
        ];
    }
}
