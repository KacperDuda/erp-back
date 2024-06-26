<?php

namespace App\Policies;

use App\Models\PriceList;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PriceListPolicy
{
    public function before(User $user, string $ability) {
        return $user->tokenCan('pricelist:all');
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->tokenCan('pricelist:viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PriceList $priceList): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan('pricelist:modify');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PriceList $priceList): bool
    {
        return $user->tokenCan('pricelist:modify');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PriceList $priceList): bool
    {
        return $user->tokenCan('pricelist:modify');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PriceList $priceList): bool
    {
        return $user->tokenCan('pricelist:modify');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PriceList $priceList): bool
    {
        return $user->tokenCan('pricelist:modify');

    }
}
