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

    protected $appends = ['canEdit', 'canDelete'];

    public function getCanEditAttribute(){
        if (Auth::user()->created_by == null || $this->created_by == Auth::user()->id)
            return true;

        $role_access = Role_Access::where('role_id',Auth::user()->role_id)
            ->where('building_id',$this->id)
            ->where('permission',"ilike","%e%")
            ->get();

        return $role_access->count() != 0;
    }

    public function getCanDeleteAttribute(){
        if (Auth::user()->created_by == null || $this->created_by == Auth::user()->id)
            return true;
        $role_access = Role_Access::where('role_id',Auth::user()->role_id)
            ->where('building_id',$this->id)
            ->where('permission',"ilike","%e%")
            ->get();

        return $role_access->count() != 0;
    }

    public function scopeWhereHasAccess($query){

        if (Auth::user()->created_by == null)
            return $query;

        else if (Auth::user()->creator->created_by == null)
            return $query->where('created_by', Auth::user()->id);

        else {
            $building_ids = Role_Access::where('role_id',Auth::user()->role_id)
                ->where('permission','ilike','%r%')
                ->select('building_id')
                ->get();

            return $query->whereIn('building_id', $building_ids);
        }
    }

}
