<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $table = 'monitors';

    public function access_point(){
        return $this->hasOne('App\Models\Access_point','id','access_point_id');
    }
}
