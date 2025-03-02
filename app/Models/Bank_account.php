<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Bank_account extends Model
{
    protected $guarded = ['id'];

    #get title
    public function getTitleAttribute()
    {
        $attr = 'title_' . App::getLocale();
        return $this->attributes[$attr];
    }
}
