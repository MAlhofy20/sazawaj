<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Exam_question extends Model
{
    protected $guarded = ['id'];

    public function exam()
    {
        return $this->belongsTo('App\Models\Exam' , 'exam_id' , 'id');
    }

    #get question
    public function getQuestionAttribute()
    {
        $attr = 'question_' . App::getLocale();
        return $this->attributes[$attr];
    }

    #get first_answer
    public function getFirstAnswerAttribute()
    {
        $attr = 'first_answer_' . App::getLocale();
        return $this->attributes[$attr];
    }

    #get second_answer
    public function getSecondAnswerAttribute()
    {
        $attr = 'second_answer_' . App::getLocale();
        return $this->attributes[$attr];
    }

    #get third_answer
    public function getThirdAnswerAttribute()
    {
        $attr = 'third_answer_' . App::getLocale();
        return $this->attributes[$attr];
    }

    #get fourth_answer
    public function getFourthAnswerAttribute()
    {
        $attr = 'fourth_answer_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
