<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $table = 'apartments';

    public function entry(){
        return $this->hasOne('App\Models\Entry','id','entry_id');
    }

    public function clients(){
        return $this->hasMany('App\Models\Client','apartment_id');
    }

}
