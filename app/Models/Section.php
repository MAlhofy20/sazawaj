<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Section extends Model
{
    protected $guarded = ['id'];

    #sub_sections
    public function sub_sections()
    {
        return $this->hasMany('App\Models\Sub_section');
    }

    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    public function media_files()
    {
        return $this->hasMany('App\Models\Media_file');
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
