<?php

namespace App\Http\Controllers;

use App\Http\Requests\addRoleRequest;
use App\Models\Relay;
use App\Models\Role;
use App\Models\Role_buildings;
use App\Models\Role_modules;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function getRole($id){

        return Role::whereId($id)->with('role_accesses')->first();
    }

    public function getRoles(){
        return Role::where('created_by', Auth::user()->id)->get();
    }

    public function getAccesses($role_id){
        return Role_buildings::where('role_id',$role_id)->get();
    }

    public function addRole(addRoleRequest $request){
        $role = new Role();
        $role->name = $request->name;
        $role->created_by = 1;//Auth::user()->id;
        $role->save();

        $this->giveAccessToModules($role->id, $request->role_modules);
        $this->giveAccessToBuildings($role->id, $request->role_buildings);

        return Role::whereId($role->id)->with('role_buildings','role_modules')->first();
    }

    public function giveAccessToModules($role_id, $request){

        foreach ($request as $value) {
            $role_modules = new Role_modules();
            $role_modules->role_id = $role_id;
            $role_modules->module = $value['module'];
            $role_modules->read = $value['read'];
            $role_modules->write = $value['write'];
            $role_modules->delete = $value['delete'];
            $role_modules->save();
        }
    }

    public function giveAccessToBuildings($role_id, $request){

        foreach ($request as $value){
            $role_access = new Role_buildings();
            $role_access->role_id = $role_id;
            $role_access->building_id = $value['building_id'];
            $role_access->read = $value['read'];
            $role_access->write = $value['write'];
            $role_access->delete = $value['delete'];
            $role_access->save();
        }

        return Role_buildings::where('role_id',$role_id)->get();
    }

    public function deleteAccessFromRole($role_access_id){

        $role_access = Role_buildings::findOrFail($role_access_id);
        $role_access->delete();
    }
}
