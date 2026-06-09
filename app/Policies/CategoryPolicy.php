<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user){
        // hanya admin yg boleh delete, selain admin dilarang keras delete
        return ($user->role == "admin") ?
        Response::allow() :
        Response::deny("Only admins are allowed to perform this operation");
    }
}
