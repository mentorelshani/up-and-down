<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    public function role_modules(){
        return $this->hasMany('App\Models\Role_modules','module_id');
    }
}
