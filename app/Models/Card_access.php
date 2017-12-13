<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card_access extends Model
{
    protected $table = 'card_accesses';

	public function card(){
        return $this->hasOne('App\Models\Card','id','card_id');
    }

    public function relay(){
        return $this->hasOne('App\Models\Relay','id','relay_id');
    }

}
