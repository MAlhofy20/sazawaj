<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class User_account extends Model
{
    protected $guarded = ['id'];

    #user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    #order
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
