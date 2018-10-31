<?php

namespace App\Policies;

use App\User;
use App\Talk;
use Illuminate\Auth\Access\HandlesAuthorization;

class TalkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the talk.
     *
     * @param  \App\User  $user
     * @param  \App\Talk  $talk
     * @return mixed
     */
    public function view(User $user, Talk $talk)
    {
        //
    }

    /**
     * Determine whether the user can create talks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the talk.
     *
     * @param  \App\User  $user
     * @param  \App\Talk  $talk
     * @return mixed
     */
    public function update(User $user, Talk $talk)
    {
        return $user->id === $talk->user_id || $user->id === $talk->receiver_id;
    }

    /**
     * Determine whether the user can delete the talk.
     *
     * @param  \App\User  $user
     * @param  \App\Talk  $talk
     * @return mixed
     */
    public function delete(User $user, Talk $talk)
    {
        //
    }

    /**
     * Determine whether the user can restore the talk.
     *
     * @param  \App\User  $user
     * @param  \App\Talk  $talk
     * @return mixed
     */
    public function restore(User $user, Talk $talk)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the talk.
     *
     * @param  \App\User  $user
     * @param  \App\Talk  $talk
     * @return mixed
     */
    public function forceDelete(User $user, Talk $talk)
    {
        //
    }
}
