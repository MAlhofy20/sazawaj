<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Service_option extends Model
{
    protected $table = 'service_options';
    protected $guarded = ['id'];

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    #get title
    public function getTitleAttribute()
    {
        $attr = 'title_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
