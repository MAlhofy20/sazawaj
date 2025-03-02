<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_time_static extends Model
{
    protected $guarded = ['id'];

    // order
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

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
}
