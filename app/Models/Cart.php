<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id'];

    #user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    #provider
    public function provider()
    {
        return $this->belongsTo('App\Models\User');
    }

    #section
    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    #service
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
    
    #size
    public function size()
    {
        return $this->belongsTo('App\Models\Service_option', 'size_id');
    }
    
    #option
    public function option()
    {
        return $this->belongsTo('App\Models\Service_option', 'option_id');
    }

    #store seen
    public function setSeenAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['seen'] = false;
        } else {
            $this->attributes['seen'] = $value;
        }
    }
}
