<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_Access extends Model
{
    protected $table = 'role_accesses';

    public function role(){
        return $this->hasOne('App\Models\Role','id','role_id');
    }

    public function building(){
        return $this->hasOne('App\Models\Building','id','building_id');
    }
}
