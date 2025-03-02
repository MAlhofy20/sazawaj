<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Sub_section_part extends Model
{
    protected $guarded = ['id'];

    #services
    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    #section
    public function sub_section()
    {
        return $this->belongsTo('App\Models\Sub_section');
    }

    #get title
    public function getTitleAttribute()
    {
        $attr = 'title_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
