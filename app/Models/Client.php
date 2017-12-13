<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    public function apartment(){
    	return $this->hasOne('App\Models\Apartment','id','apartment_id');
    }

	public function cards(){
        return $this->hasMany('App\Models\Card','client_id');
    }

    public function payments(){
        return $this->hasMany('App\Models\Payment','client_id');
    }
}
