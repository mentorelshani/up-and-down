<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_buildings extends Model
{
    protected $table = 'role_buildings';

    public function role(){
        return $this->hasOne('App\Models\Role','id','role_id');
    }

    public function building(){
        return $this->hasOne('App\Models\Building','id','building_id');
    }
}
