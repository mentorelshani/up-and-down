<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $table = 'versions';

    public function access_points(){
        return $this->hasMany('App\Models\Access_point','version_id');
    }
}
