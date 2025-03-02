<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Visitor extends Model
{
    protected $guarded = ['id'];

    #user
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    #to
    public function to()
    {
        return $this->belongsTo('App\Models\User', 'to_id');
    }
}
