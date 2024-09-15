<?php

namespace App\Policies;

use App\Models\User;
use App\Models\settings;
use Illuminate\Auth\Access\Response;

class SettingsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function view_settings(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update_settings(User $user): bool
    {
        return $user->hasRole('rental-admin');
    }
}