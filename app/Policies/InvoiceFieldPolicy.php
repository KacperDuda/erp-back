<?php

namespace App\Policies;

use App\Models\InvoiceField;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoiceFieldPolicy
{
    public function before(User $user) {
        if($user->tokenCan('invoice:all')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->tokenCan('invoice:viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InvoiceField $invoiceField): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan('invoice:modify');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InvoiceField $invoiceField): bool
    {
        return $user->tokenCan('invoice:modify');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InvoiceField $invoiceField): bool
    {
        return $user->tokenCan('invoice:modify');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InvoiceField $invoiceField): bool
    {
        return $user->tokenCan('invoice:modify');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InvoiceField $invoiceField): bool
    {
        return $user->tokenCan('invoice:modify');
    }
}
