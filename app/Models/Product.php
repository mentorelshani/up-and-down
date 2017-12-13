<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

	public function payments(){
        return $this->hasMany('App\Models\Payment','product_id');
    }

}
