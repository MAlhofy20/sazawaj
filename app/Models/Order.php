<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Order extends Model
{
    protected $guarded = ['id'];

    // user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // provider
    public function provider()
    {
        return $this->belongsTo('App\Models\User', 'provider_id');
    }

    // delegate
    public function delegate()
    {
        return $this->belongsTo('App\Models\User', 'delegate_id');
    }

    // order
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    // orders
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function files()
    {
        return $this->hasMany('App\Models\Order_file');
    }

    // start_city
    public function start_city()
    {
        return $this->belongsTo('App\Models\City', 'start_city_id');
    }

    // end_city
    public function end_city()
    {
        return $this->belongsTo('App\Models\City', 'end_city_id');
    }

    // section
    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    // order_items
    public function order_items()
    {
        return $this->hasMany('App\Models\Order_item');
    }

    #get section_title
    public function getSectionTitleAttribute()
    {
        $attr = 'section_title_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
