<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PropertyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny_property(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager|rental-staff');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view_property(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager|rental-staff');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create_property(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager|rental-staff');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update_property(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete_property(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }
}