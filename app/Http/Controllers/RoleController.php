<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Role_Access;
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
        return Role_Access::where('role_id',$role_id)->get();
    }

    public function addRole(Request $request){
        $role = new Role();
        $role->name = $request->name;
        $role->created_by = Auth::user()->id;
        $role->save();

        return $role;
    }

    public function deleteAccessFromRole($role_access_id){

        $role_access = Role_Access::findOrFail($role_access_id);
        $role_access->delete();
    }

    public function giveAccessToRole(Request $request){

        $role_id = $request->role_id;
        $array = $request->array;

        foreach ($array as $a){
            $role_access = new Role_Access();
            $role_access->role_id = $role_id;
            $role_access->building_id = $a->building_id;
            $role_access->permission = $a->permission;
            $role_access->save();
        }

        return Role_Access::where('role_id',$role_id)->get();
    }

    public function asd(){

        return Laracurl::get('/getEntry/2');

        $res = $client->get('/getEntry/2');
        echo $res->getBody();

        return;
//        return $response;

        $this->validate($request,[
            'imei' => 'digits_between:1,17'
        ]);

        return $request->imei . " shum i fort";

        $image = $request->file('file');

        $fileName = "tinuk.png";

        $image->move(public_path("/uploads"), $fileName);
    }

}
