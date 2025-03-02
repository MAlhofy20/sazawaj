<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City_delivery extends Model
{
    protected $guarded  = ['id'];
    protected $table    = 'city_deliverys';

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function city_to()
    {
        return $this->belongsTo('App\Models\City', 'city_to_id');
    }
}
