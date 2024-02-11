<?php

namespace App\Policies;

use App\Models\PriceListElement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PriceListElementPolicy
{
    public function before(User $user,string $ability)
    {
        if($user->tokenCan('pricelistelement:all')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->tokenCan('pricelistelement:viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PriceListElement $priceListElement): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan('pricelistelement:modify');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PriceListElement $priceListElement): bool
    {
        return $user->tokenCan('pricelistelement:modify');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PriceListElement $priceListElement): bool
    {
        return $user->tokenCan('pricelistelement:modify');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PriceListElement $priceListElement): bool
    {
        return $user->tokenCan('pricelistelement:modify');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PriceListElement $priceListElement): bool
    {
        return $user->tokenCan('pricelistelement:modify');
    }
}
