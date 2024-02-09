<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    // example verification with tokens
    public function entryAdd(User $user) {
        return $user->tokenCan('entry:add');
    }
}
