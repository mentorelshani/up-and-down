<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Access_point extends Model
{
    protected $table = 'access_points';

    public function version(){
        return $this->hasOne('App\Models\Version','id','version_id');
    }

    public function elevator(){
        return $this->hasOne('App\Models\Elevator','id','elevator_id');
    }

    public function relays(){
        return $this->hasMany('App\Models\Relay','access_point_id');
    }

    public function monitors(){
        return $this->hasMany('App\Models\Monitor','access_point_id');
    }

}
