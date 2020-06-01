<?php


namespace Tests\Traits;


use App\Models\Role;

trait RegisterRolesAndPermissions
{
    public function registerRolesAndPermissions()
    {
        Role::create(['name' => 'user']);
        Role::create(['name' => 'seller']);
        Role::create(['name' => 'admin']);
    }
}
