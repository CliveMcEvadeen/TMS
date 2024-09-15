<?php

namespace App\Policies;

use App\Models\User;
use App\Models\owner;
use Illuminate\Auth\Access\Response;

class OwnerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny_owners(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view_owners(User $user, owner $owner): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create_owners(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update_owners(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete_owners(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }
}