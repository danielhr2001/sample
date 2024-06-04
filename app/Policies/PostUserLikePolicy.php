<?php

namespace App\Policies;

use App\Models\PostUserLike;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostUserLikePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostUserLike $postUserLike): Response
    {
        return $user->id === $postUserLike->user_id
            ? Response::allow()
            : Response::deny('این لایک متعلق به شما نیست.');
    }
}
