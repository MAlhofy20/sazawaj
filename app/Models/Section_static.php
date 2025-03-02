<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Section_static extends Model
{
    protected $guarded = ['id'];

    #user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
