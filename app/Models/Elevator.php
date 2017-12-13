<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Elevator extends Model
{
    protected $table = 'elevators';

    public function entry(){
        return $this->hasOne('App\Models\Entry','id','entry_id');
    }

    public function access_points(){
        return $this->hasMany('App\Models\Access_point','elevator_id');
    }
}
