<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine if the user can view any posts.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('posts.view');
    }

    /**
     * Determine if the user can view the post.
     */
    public function view(User $user, Post $post): bool
    {
        if ($user->can('posts.view')) {
            return true;
        }

        // Author can view their own posts
        return $user->hasRole('author') && $post->user_id === $user->id;
    }

    /**
     * Determine if the user can create posts.
     */
    public function create(User $user): bool
    {
        return $user->can('posts.create');
    }

    /**
     * Determine if the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        // Admin and Editor can edit any post
        if ($user->can('posts.edit')) {
            return true;
        }

        // Author can only edit their own posts
        return $user->can('posts.edit.own') && $post->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        // Admin and Editor can delete any post
        if ($user->can('posts.delete')) {
            return true;
        }

        // Author can only delete their own posts
        return $user->can('posts.delete.own') && $post->user_id === $user->id;
    }

    /**
     * Determine if the user can restore the post.
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->can('posts.delete');
    }

    /**
     * Determine if the user can permanently delete the post.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->can('posts.delete');
    }
}
