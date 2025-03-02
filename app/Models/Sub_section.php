<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Sub_section extends Model
{
    protected $guarded = ['id'];

    #section
    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    #get title
    public function getTitleAttribute()
    {
        $attr = 'title_' . App::getLocale();
        return $this->attributes[$attr];
    }

    #get short_desc
    public function getShortDescAttribute()
    {
        $attr = 'short_desc_' . App::getLocale();
        return $this->attributes[$attr];
    }

    #get desc
    public function getDescAttribute()
    {
        $attr = 'desc_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
