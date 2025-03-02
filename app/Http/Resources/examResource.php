<?php

namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\questionResource;
use App;
use App\Models\Exam_question;

class examResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'             => (int)    $this->id,
            'title'          => (string) $this->title_ar,
            'questions'      => questionResource::collection($this->questions)
        ];
    }
}
