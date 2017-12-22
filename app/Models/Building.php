<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Building extends Model
{
    protected $table = 'buildings';

    public function creator(){
        return $this->hasOne('App\User','id','created_by');
    }

    public function address(){
        return $this->hasOne('App\Models\Address','id','address_id');
    }

    public function role_accesses(){
        return $this->hasMany('App\Models\Role_access','building_id');
    }

    public function entries(){
    	return $this->hasMany('App\Models\Entry','building_id');
    }

    protected $appends = [ 'canRead', 'canEdit', 'canDelete'];

    public function getCanReadAttribute(){
        return true;
    }

    public function getCanEditAttribute(){
        return true;
    }

    public function getCanDeleteAttribute(){
        return true;
    }

    public function scopeWhereHasAccess ($query){
        if (true)//Auth::user()->created_by == null)
            return $query;

        else if (Auth::user()->creator->created_by == null)
            return $query->where('created_by' , Auth::user()->id);

        return $query->where('created_by', Auth::user()->creator->id);
    }



}
