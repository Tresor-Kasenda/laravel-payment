<?php

namespace App\Policies;

use App\Models\BlogPost;
use App\Models\User;

class BlogPostPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, BlogPost $blogPost): bool
    {
        if (! $blogPost->visible_to_subscribers_only) {
            return true;
        }

        if (! $user) {
            return false;
        }

        if ($user->id === $blogPost->author_id) {
            return true;
        }

        return $user->hasActiveSubscription();
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, BlogPost $blogPost): bool
    {
        return $user->id === $blogPost->author_id;
    }

    public function delete(User $user, BlogPost $blogPost): bool
    {
        return $user->id === $blogPost->author_id;
    }

    public function restore(User $user, BlogPost $blogPost): bool
    {
        return $user->id === $blogPost->author_id;
    }

    public function forceDelete(User $user, BlogPost $blogPost): bool
    {
        return $user->id === $blogPost->author_id;
    }
}
