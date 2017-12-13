<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relay extends Model
{
    protected $table = 'relays';

	public function access_point(){
        return $this->hasOne('App\Models\Access_point','id','access_point_id');
    }

    public function card_accesses(){
        return $this->hasMany('App\Models\Card_access','relay_id');
    }

    public function check_ins(){
        return $this->hasMany('App\Models\Check_in','relay_id');
    }

    public function invalid_check_ins(){
        return $this->hasMany('App\Models\Invalid_check_in','relay_id');
    }
}
