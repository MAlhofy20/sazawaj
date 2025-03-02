<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = ['id'];

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
