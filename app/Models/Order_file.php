<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_file extends Model
{
    protected $guarded = ['id'];

    // order
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
