<?php

namespace App\Repositories\Role;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Role;

class EloquentRoleRepository implements RoleRepository
{

    public function fetchRole()
    {
        $roles = Role::get();
        return $roles;
    }
}