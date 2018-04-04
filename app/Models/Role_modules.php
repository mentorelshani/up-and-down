<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_modules extends Model
{
    protected $table = 'role_modules';

    public function role(){
        return $this->hasOne('App\Models\Role','id','role_id');
    }
}
