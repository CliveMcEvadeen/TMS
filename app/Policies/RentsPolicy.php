<?php

namespace App\Policies;

use App\Models\Rents;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RentsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny_rents(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view_rents(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create_rents(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }

    /**
     * Determine whether the user can create models.
     */
    public function payment_rents(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update_rents(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete_rents(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }
}