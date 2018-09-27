<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
        'id','text','sender_id','resiver_id','date','satus'
    ];


}
