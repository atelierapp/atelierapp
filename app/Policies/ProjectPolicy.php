<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Bouncer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Project $project)
    {
        return Bouncer::is($user)->an('admin') OR Bouncer::can('view', $project);
    }

    public function create(User $user)
    {
        return Bouncer::is($user)->a('user');
    }

    public function update(User $user, Project $project)
    {
        return Bouncer::is($user)->an('admin') || Bouncer::can('update', $project);
    }

    public function delete(User $user, Project $project)
    {
        return Bouncer::is($user)->an('admin') || Bouncer::can('delete', $project);
    }

    public function restore(User $user, Project $project)
    {
        return Bouncer::is($user)->an('admin') || Bouncer::can('restore', $project);
    }

    public function forceDelete(User $user, Project $project)
    {
        return Bouncer::is($user)->an('admin') || Bouncer::can('force-delete', $project);
    }
}
