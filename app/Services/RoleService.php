<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function isAdminOrSeller(): bool
    {
        return \Bouncer::is(auth()->user())->a(Role::SELLER, Role::ADMIN);
    }
}
