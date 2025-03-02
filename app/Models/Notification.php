<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Notification extends Model
{
    protected $guarded = ['id'];

    #store seen
    public function setSeenAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['seen'] = 0;
        } else {
            $this->attributes['seen'] = $value;
        }
    }

    #get message
    public function getMessageAttribute()
    {
        $attr = 'message_' . App::getLocale();
        return $this->attributes[$attr];
    }

    static function unSeenMessage($to_id)
    {
        if (empty($to_id)) return 0;

        $notifications = self::where('to_id', $to_id)->where('seen', 0)->count();
        return $notifications;
    }
}
