<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function modify(User $user, Post $post): Response
{
    // Ha a felhasználó az admin, akkor engedélyezze a módosítást
    if ($user->admin === 'Admin') {
        return Response::allow();
    }

    // Ha a felhasználó azonos a poszt tulajdonosával, akkor is engedélyezze
    return $user->id === $post->user_id
        ? Response::allow()
        : Response::deny('You do not own this post');
}

}
