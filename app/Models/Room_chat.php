<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room_chat extends Model
{
    protected $guarded = ['id'];

    // from
    public function from()
    {
        return $this->belongsTo('App\Models\User', 'from_id');
    }

    // to
    public function to()
    {
        return $this->belongsTo('App\Models\User', 'to_id');
    }

    // room
    public function room()
    {
        return $this->hasMany('App\Models\Room');
    }
}
