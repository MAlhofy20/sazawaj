<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $guarded = ['id'];

    #user
    public function user()
    {
        return $this->belongsTo('App\Models\User' , 'user_id');
    }

    #provider
    public function provider()
    {
        return $this->belongsTo('App\Models\User' , 'provider_id');
    }

    #delegate
    public function delegate()
    {
        return $this->belongsTo('App\Models\User' , 'delegate_id');
    }

    // section
    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }
    
    // service
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
