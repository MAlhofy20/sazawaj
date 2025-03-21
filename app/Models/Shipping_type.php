<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Shipping_type extends Model
{
    protected $guarded = ['id'];

    #get title
    public function getTitleAttribute()
    {
        $attr = 'title_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
