<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check_in extends Model
{
    protected $table = 'check_ins';

	public function card(){
        return $this->hasOne('App\Models\Card','id','card_id');
    }

    public function relay(){
        return $this->hasOne('App\Models\Relay','id','relay_id');
    }
}
