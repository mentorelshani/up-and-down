<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->hasOne('App\Models\Role','id','role_id');
    }

    public function creator(){
        return $this->hasOne('App\User','id','created_by');
    }

    public function childs(){
        return $this->hasMany('App\User','created_by');
    }

    public function buildings(){
        return $this->hasMany('App\Models\Building','created_by');
    }


}
