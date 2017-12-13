<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    public function city(){
         return $this->hasOne('App\Models\City','id','city_id');
    }
    public function buildings(){
        return $this->hasMany('App\Models\Building','address_id');
    }
}
