<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
    public function before(User $user)
    {
        if($user->tokenCan('client:all')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->tokenCan('client:viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Client $client): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan('client:modify');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        return $user->tokenCan('client:modify');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        return $user->tokenCan('client:modify');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Client $client): bool
    {
        return $user->tokenCan('client:modify');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Client $client): bool
    {
        return $user->tokenCan('client:modify');

    }
}
