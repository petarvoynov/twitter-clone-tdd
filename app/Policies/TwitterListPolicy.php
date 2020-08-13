<?php

namespace App\Policies;

use App\TwitterList;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TwitterListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any twitter lists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the twitter list.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterList  $twitterList
     * @return mixed
     */
    public function view(User $user, TwitterList $twitterList)
    {
        //
    }

    /**
     * Determine whether the user can create twitter lists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the twitter list.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterList  $twitterList
     * @return mixed
     */
    public function update(User $user, TwitterList $list)
    {
        return $user->id == $list->user_id;
    }

    /**
     * Determine whether the user can delete the twitter list.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterList  $twitterList
     * @return mixed
     */
    public function delete(User $user, TwitterList $twitterList)
    {
        //
    }

    /**
     * Determine whether the user can restore the twitter list.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterList  $twitterList
     * @return mixed
     */
    public function restore(User $user, TwitterList $twitterList)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the twitter list.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterList  $twitterList
     * @return mixed
     */
    public function forceDelete(User $user, TwitterList $twitterList)
    {
        //
    }
}
