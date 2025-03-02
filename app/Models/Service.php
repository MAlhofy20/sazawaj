<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Service extends Model
{
    protected $guarded = ['id'];

    #images
    public function images()
    {
        return $this->hasMany('App\Models\Service_image');
    }
    
    #rates
    public function rates()
    {
        return $this->hasMany('App\Models\Rate');
    }

    #offers
    public function offers()
    {
        return $this->hasMany('App\Models\Service_offer');
    }
    
    #sizes
    public function sizes()
    {
        return $this->hasMany('App\Models\Service_option')->where('type', 'size');
    }
    
    #options
    public function options()
    {
        return $this->hasMany('App\Models\Service_option')->where('type', 'option');
    }

    #sides
    public function sides()
    {
        return $this->hasMany('App\Models\Service_option')->where('type', 'side');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

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
