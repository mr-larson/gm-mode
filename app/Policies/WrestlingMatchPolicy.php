<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WrestlingMatch;
use Illuminate\Auth\Access\Response;

class WrestlingMatchPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WrestlingMatch $wrestlingMatch): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WrestlingMatch $wrestlingMatch): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WrestlingMatch $wrestlingMatch): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WrestlingMatch $wrestlingMatch): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WrestlingMatch $wrestlingMatch): bool
    {
        return false;
    }
}
