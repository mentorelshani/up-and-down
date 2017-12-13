<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $table = 'entries';

    public function building(){
        return $this->hasOne('App\Models\Building','id','building_id');
    }

    public function elevators(){
        return $this->hasMany('App\Models\Elevator','entry_id');
    }

    public function apartments(){
        return $this->hasMany('App\Models\Apartment','entry_id');
    }
}
