<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class User_note extends Model
{
    protected $guarded = ['id'];

    #user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
