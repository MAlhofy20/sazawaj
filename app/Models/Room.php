<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Room extends Model
{
    protected $guarded = ['id'];

    // user
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    // saler
    public function saler()
    {
        return $this->belongsTo('App\Models\User', 'saler_id');
    }

    // chats
    public function chats()
    {
        return $this->hasMany('App\Models\Room_chat');
    }

    public function getHaveUnseenMessageAttribute()
    {
        return $this->chats()->where('to_id', auth()->id())->where('seen', 0)->exists();
    }

    // chats_desc
    public function chats_desc()
    {
        return $this->hasMany('App\Models\Room_chat')->orderBy('created_at', 'desc');
    }
}
