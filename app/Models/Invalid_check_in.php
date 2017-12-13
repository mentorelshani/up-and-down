<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invalid_check_in extends Model
{
    protected $table = 'invalid_check_ins';

    public function relay(){
        return $this->hasOne('App\Models\Relay','id','relay_id');
    }
}
