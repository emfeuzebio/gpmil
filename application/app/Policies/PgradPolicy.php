<?php

namespace App\Policies;

use App\Models\Pgrad;
use App\Models\User;

class PgradPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function store(User $user, Pgrad $pgrad)
    {
        // return $user->id === $pgrad->user_id;
        echo "function store()";
        // return true;
    }    
}
