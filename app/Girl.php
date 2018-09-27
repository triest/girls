<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Girl extends Model
{
    //
    protected $fillable = [
        'name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','publicated',
        'money','beginvip','endvip','sex','meet','weight','height','country_id','region_id','city_id'
    ];


    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function getVip(){
        $current_date=Carbon::now();
        $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description'])
            ->where('beginvip','<',$current_date)
            ->where('endvip','>',$current_date)
            ->orderBy('created_at','DESC')
            ->orderBy('rating','ASC');

        return $vipGirls;
    }
}
