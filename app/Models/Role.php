<?php

namespace App\Models;

use Silber\Bouncer\Database\Role as RoleModel;

/**
 * @mixin IdeHelperRole
 */
class Role extends RoleModel
{
    public const USER = 'user';
    public const ADMIN = 'admin';
    public const SELLER = 'seller';
}
