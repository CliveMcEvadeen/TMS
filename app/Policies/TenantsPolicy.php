<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tenants;
use Illuminate\Auth\Access\Response;

class TenantsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny_tenant(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager|rental-staff');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tenants $tenant): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create_tenant(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager|rental-staff');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update_tenant(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager|rental-staff');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete_tenant(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }
}