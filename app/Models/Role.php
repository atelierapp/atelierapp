<?php

namespace App\Models;

use Silber\Bouncer\Database\Role as RoleModel;

class Role extends RoleModel
{
    const USER = 'user';
    const ADMIN = 'admin';
    const SELLER = 'seller';
}
