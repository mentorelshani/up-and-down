<?php

namespace App\Http\Controllers;

use App\Http\Requests\addUserRequest;
use App\Http\Requests\updateUserRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Find All Users
     *
     * @return mixed
     */
    public function index(){

        $users = User::whereHasAccess()->get();

        return $users;
    }

    /**
     * Find user by id
     *
     * @param $id
     * @return mixed
     */
    public function show($id){

        $user = User::find($id);

        return $user;
    }

    /**
     * Store user
     *
     * @param Request $request
     * @return User
     */
    public function store(addUserRequest $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->created_by = Auth::user()->id;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();

        $user->load('role.role_buildings','role.role_modules');

        return $user;
    }


    /**
     * Update user
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(updateUserRequest $request)
    {
        $user = User::findOrfail($request->id);
        $user->username = $request->username;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->update();

        $user->load('role.role_buildings','role.role_modules');

        return $user;
    }

    /**
     * Delete user
     *
     * @param $id
     */
    public function destroy($id){

        $user = User::find($id);

        $user->delete();
    }




}
