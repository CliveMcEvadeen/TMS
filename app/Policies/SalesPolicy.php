<?php

namespace App\Policies;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SalesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny_sales(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view_sales(User $user, Sales $sales): bool
    {
        return $user->hasRole('rental-admin|rental-manager');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create_sales(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');

    }

    public function update_sales(User $user): bool
    {
        return $user->hasRole('rental-admin|rental-manager');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete_sales(User $user, Sales $sales): bool
    {
        return $user->hasRole('rental-admin');

    }
}