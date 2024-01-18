<?php

namespace App\Policies;

use App\Models\BlogComment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class BlogCommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BlogComment $blogComment): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create_comment(User $user): bool
    {
        return $user->id === Auth::id();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update_comment(User $user, BlogComment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete_comment(User $user, BlogComment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BlogComment $blogComment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BlogComment $blogComment): bool
    {
        //
    }
}
