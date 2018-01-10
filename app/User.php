<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

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

    protected $appends = ['canEdit', 'canDelete'];

    public function getCanEditAttribute(){
        if (true){//Auth::user()->created_by == null) {
            return true;
        }
        else if (Auth::user()->id == $this->created_by){
            return true;
        }
        else if (Auth::user()->id == $this->id){
            return true;
        }
        else
            return false;
    }

    public function getCanDeleteAttribute(){
        return true;
    }

    public function scopeWhereHasAccess($query){
        if (true)//Auth::user()->created_by == null)
            return $query;

        else if (Auth::user()->creator->created_by == null)
            return $query->where('created_by' , Auth::user()->id);

        return $query->where('created_by', Auth::user()->creator->id);
    }

}
