<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Page extends Model
{
    protected $guarded = ['id'];

    #get title
    public function getTitleAttribute()
    {
        $attr = 'title_' . App::getLocale();
        return $this->attributes[$attr];
    }

    #get desc
    public function getDescAttribute()
    {
        $attr = 'desc_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
