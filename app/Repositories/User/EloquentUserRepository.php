<?php

namespace App\Repositories\User;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;

class EloquentUserRepository implements UserRepository
{

    public function fetchUser()
    {
        $query_builder = User::where('status', 1);
        return $query_builder;
    }

    public function fetchUserById($id)
    {
        $user = $this->fetchUser()->where('id', $id)->first();
        return $user;
    }

    public function fetchAccountManager()
    {
        $account_manager = $this->fetchUser()->where('role_id', 2)->get();
        return $account_manager;
    }

    public function fetchTeacher()
    {
        $teachers = $this->fetchUser()->where('role_id', 4)->get();
        return $teachers;
    }

    public function insertUser(UserRequest $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        if($request->role_id === '4' || $request->role_id === '5'){
            $user->location_id = $request->location_id;
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }

    public function updateUser(UserUpdateRequest $request)
    {
        $user = $this->fetchUserById($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request->password)){
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->fetchUserById($id);
        if(isset($user)){
            $user->status = 0;
        }
        $user->save();
        return $user;
    }
}