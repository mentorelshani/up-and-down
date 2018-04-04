<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function users(){
        return $this->hasMany('App\User','role_id');
    }

    public function role_buildings(){
        return $this->hasMany('App\Models\Role_buildings','role_id');
    }

    public function role_modules(){
        return $this->hasMany('App\Models\Role_modules','role_id');
    }
}
