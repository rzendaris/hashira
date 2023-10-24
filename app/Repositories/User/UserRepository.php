<?php

namespace App\Repositories\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;

interface UserRepository {
    public function fetchUser();
    public function fetchUserById($id);
    public function fetchAccountManager();
    public function insertUser(UserRequest $request);
    public function updateUser(UserUpdateRequest $request);
    public function deleteUser($id);
}
