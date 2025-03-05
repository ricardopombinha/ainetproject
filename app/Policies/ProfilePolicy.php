<?php

namespace App\Policies;

use App\Models\User;

class ProfilePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function before(?User $user, string $ability): bool|null
    {
        if($user->type == 'A'){
            return true;
        }
        // When "Before" returns null, other methods (eg. viewAny, view, etc...) will be
        // used to check the user authorizaiton
        return null;
    }

    public function create(User $user): bool
    {
        return $user->type == 'A';
    }

    public function update(User $user): bool
    {
        return $user->type == 'C' || $user->type == 'A';
        //return true;
    }

    public function viewAny(User $user): bool
    {
        return $user->type == 'A';
    }
}
