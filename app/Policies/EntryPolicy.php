<?php

namespace App\Policies;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EntryPolicy
{
    protected function limitedSufficient(User $user, Entry $entry):bool
    {
        if($entry->posting_date >= Entry::getLimitDate() && $user->tokenCan('entry:limited'))
        {
            return true;
        }
        return false;
    }

    public function before(User $user) {
        if($user->tokenCan('entry:all'))
        {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->tokenCan('entry:viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Entry $entry): bool
    {
        if($this->limitedSufficient($user, $entry)) {
            return true;
        }
        return $this->viewAny($user);
    }



    /**
     * Determine whether the user can update/create/delete/... the model.
     */
    public function modify(User $user, Entry $entry): bool
    {
        if($this->limitedSufficient($user, $entry)) {
            return true;
        }
        return $user->tokenCan('entry:modify');
    }

}
