<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;

class AdPolicy
{
    /**
     * Determine if the user can view any ads.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('ads.view');
    }

    /**
     * Determine if the user can view the ad.
     */
    public function view(User $user, Ad $ad): bool
    {
        return $user->can('ads.view');
    }

    /**
     * Determine if the user can create ads.
     */
    public function create(User $user): bool
    {
        return $user->can('ads.create');
    }

    /**
     * Determine if the user can update the ad.
     */
    public function update(User $user, Ad $ad): bool
    {
        return $user->can('ads.edit');
    }

    /**
     * Determine if the user can delete the ad.
     */
    public function delete(User $user, Ad $ad): bool
    {
        return $user->can('ads.delete');
    }

    /**
     * Determine if the user can restore the ad.
     */
    public function restore(User $user, Ad $ad): bool
    {
        return $user->can('ads.delete');
    }

    /**
     * Determine if the user can permanently delete the ad.
     */
    public function forceDelete(User $user, Ad $ad): bool
    {
        return $user->can('ads.delete');
    }
}
