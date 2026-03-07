<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    /**
     * Determine if the user can view any pages.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('pages.view');
    }

    /**
     * Determine if the user can view the page.
     */
    public function view(User $user, Page $page): bool
    {
        if ($user->can('pages.view')) {
            return true;
        }

        // Author can view their own pages
        return $user->hasRole('author') && $page->user_id === $user->id;
    }

    /**
     * Determine if the user can create pages.
     */
    public function create(User $user): bool
    {
        return $user->can('pages.create');
    }

    /**
     * Determine if the user can update the page.
     */
    public function update(User $user, Page $page): bool
    {
        // Admin and Editor can edit any page
        if ($user->can('pages.edit')) {
            return true;
        }

        // Author can only edit their own pages
        return $user->can('pages.edit.own') && $page->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the page.
     */
    public function delete(User $user, Page $page): bool
    {
        // Cannot delete homepage
        if ($page->is_homepage) {
            return false;
        }

        // Admin and Editor can delete any page
        if ($user->can('pages.delete')) {
            return true;
        }

        // Author can only delete their own pages
        return $user->can('pages.delete.own') && $page->user_id === $user->id;
    }

    /**
     * Determine if the user can restore the page.
     */
    public function restore(User $user, Page $page): bool
    {
        return $user->can('pages.delete');
    }

    /**
     * Determine if the user can permanently delete the page.
     */
    public function forceDelete(User $user, Page $page): bool
    {
        return $user->can('pages.delete');
    }
}
