<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Exam extends Model
{
    protected $guarded = ['id'];
    protected $table = 'exams';

    public function page()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Exam_question' , 'exam_id' , 'id');
    }

    #get title
    public function getTitleAttribute()
    {
        $attr = 'title_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
