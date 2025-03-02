<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Media_file extends Model
{
    protected $guarded = ['id'];

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    #images
    public function images()
    {
        return $this->hasMany('App\Models\Media_image', 'media_id');
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
    
    #get address
    public function getAddressAttribute()
    {
        $attr = 'address_' . App::getLocale();
        return $this->attributes[$attr];
    }
    
    #get section_title
    public function getSectionTitleAttribute()
    {
        $attr = 'section_title_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
