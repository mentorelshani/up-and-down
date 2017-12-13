<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public function client(){
        return $this->hasOne('App\Models\Client','id','client_id');
    }
}
