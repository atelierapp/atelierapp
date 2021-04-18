<?php

namespace App\Policies;

use App\Models\User;
use Bouncer;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, User $model)
    {
        return Bouncer::is($user)->an('admin') OR $user->id == $model->id;
    }

    public function create(User $user)
    {
        return Bouncer::is($user)->an('admin');
    }

    public function update(User $user, User $model)
    {
        return Bouncer::is($user)->an('admin') || $user->id == $model->id;
    }

    public function delete(User $user, User $model)
    {
        return Bouncer::is($user)->an('admin') || $user->id == $model->id;
    }

    public function restore(User $user, User $model)
    {
        return Bouncer::is($user)->an('admin') || $user->id == $model->id;
    }

    public function forceDelete(User $user, User $model)
    {
        return Bouncer::is($user)->an('admin') || $user->id == $model->id;
    }

    public function uploadFiles(User $user)
    {
        return Bouncer::is($user)->an('admin');
    }
}
