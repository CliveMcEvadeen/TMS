<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view_user(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create_user(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update_user(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }

    public function update_user_(User $user, User $model): bool
    {
        return $user->hasRole('rental-admin') || $user->id === $model->id;
    }

    public function reset_user(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete_user(User $user, User $model): bool
    {
        return $user->hasRole('rental-admin') || $user->id === $model->id;
    }
}