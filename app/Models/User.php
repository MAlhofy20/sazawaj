<?php

namespace App\Models;

use App;
use App\Role;
use Carbon\Carbon;
use App\Models\Session;
use Laravel\Sanctum\HasApiTokens;
//use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    // العلاقة بين المستخدم والجلسات
    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id');
    }

    public function getIsStillOnlineAttribute(): bool
    {
        $latestSession = $this->sessions()->latest('last_activity')->first();

        if (!$latestSession) {
            return false; // لا يوجد سجل جلسات
        }

        return Carbon::createFromTimestamp($latestSession->last_activity)->gt(now()->subHours(2));
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function provider()
    {
        return $this->belongsTo('App\Models\User', 'provider_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function neighborhood()
    {
        return $this->belongsTo('App\Models\Neighborhood');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    public function sub_section()
    {
        return $this->belongsTo('App\Models\Sub_section');
    }

    public function markets()
    {
        return $this->hasMany('App\Models\User', 'manager_id')->where('user_type', 'market');
    }

    public function block_lists()
    {
        return $this->hasMany('App\Models\User_block_list');
    }

    public function visitors()
    {
        return $this->hasMany('App\Models\Visitor');
    }

    public function favourites()
    {
        return $this->hasMany('App\Models\Favourite');
    }

    public function my_block_lists()
    {
        return $this->hasMany('App\Models\User_block_list', 'to_id');
    }

    public function my_visitors()
    {
        return $this->hasMany('App\Models\Visitor', 'to_id');
    }

    public function my_favourites()
    {
        return $this->hasMany('App\Models\Favourite', 'to_id');
    }

    public function notes()
    {
        return $this->hasMany('App\Models\User_note');
    }

    public function neighborhoods()
    {
        return $this->hasMany('App\Models\User_neighborhood');
    }

    public function devices()
    {
        return $this->hasMany('App\Models\Device');
    }

    public function images()
    {
        return $this->hasMany('App\Models\User_image');
    }

    public function times()
    {
        return $this->hasMany('App\Models\User_time');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\User_address');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Service_offer', 'user_id');
    }

    public function packages()
    {
        return $this->hasMany('App\Models\Package', 'user_id')->whereType('package');
    }

    public function exercises()
    {
        return $this->hasMany('App\Models\Package', 'user_id')->whereType('exercise');
    }

    public function not_now_offers()
    {
        return $this->hasMany('App\Models\Not_now_offer')->where('delete', '!=', '1');
    }

    public function sub_sections()
    {
        return $this->hasMany('App\Models\Sub_section');
    }

    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    public function provider_orders()
    {
        return $this->hasMany('App\Models\Order', 'provider_id');
    }

    public function provider_current_orders()
    {
        return $this->hasMany('App\Models\Order', 'provider_id')->whereNotIn('status', ['finish', 'refused', 'cancel']);
    }

    #store phone
    public function setPhoneAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['phone'] = NULL;
        } else {
            $this->attributes['phone'] = convert_to_english($value);
        }
    }

    #store email
    public function setEmailAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['email'] = NULL;
        } else {
            $this->attributes['email'] = $value;
        }
    }

    #store lang
    public function setLangAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['lang'] = 'ar';
        } else {
            $this->attributes['lang'] = $value;
        }
    }

    #store phone_code
    public function setPhoneCodeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['phone_code'] = '966';
        } else {
            $this->attributes['phone_code'] = $value;
        }
    }

    #store password
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) $this->attributes['password'] = bcrypt($value);
    }

    #get name
    public function getNameAttribute()
    {
        $first_name = !empty($this->attributes['first_name']) ? $this->attributes['first_name'] : '';
        $last_name  = !empty($this->attributes['last_name']) ? $this->attributes['last_name'] : '';
        return !empty($this->attributes['full_name']) ?
            trim($this->attributes['full_name']) : trim($first_name . ' ' . $last_name);
    }

    #get full phone
    public function getFullPhoneAttribute()
    {
        return isset($this->attributes['phone_code'])
            ?
            convert_phone_to_international_format($this->attributes['phone'], $this->attributes['phone_code'])
            :
            convert_phone_to_international_format($this->attributes['phone']);
    }

    #get desc
    public function getDescAttribute()
    {
        $attr = 'desc_' . App::getLocale();
        return $this->attributes[$attr];
    }

    public function getAddressAttribute()
    {
        $attr = 'address_' . App::getLocale();
        return $this->attributes[$attr];
    }

    public function getFullNameAttribute()
    {
        $attr = 'full_name_' . App::getLocale();
        return $this->attributes[$attr];
    }


}
