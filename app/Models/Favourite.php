<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Favourite extends Model
{
    protected $guarded = ['id'];

    #user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    #to
    public function to()
    {
        return $this->belongsTo('App\Models\User', 'to_id');
    }

    #service
    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
}
