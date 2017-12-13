<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

	public function client(){
        return $this->hasOne('App\Models\Client','id','client_id');
    }

    public function card_accesses(){
        return $this->hasMany('App\Models\Card_access','card_id');
    }

}
