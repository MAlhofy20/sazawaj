<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Not_now_offer extends Model
{
    protected $guarded = ['id'];

    // user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // saler
    public function saler()
    {
        return $this->belongsTo('App\Models\User' , 'saler_id' , 'id');
    }
}
