<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class User_time_static extends Model
{
    protected $guarded = ['id'];

    #user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    #time
    public function time()
    {
        return $this->belongsTo('App\Models\User_time', 'user_time_id');
    }
}