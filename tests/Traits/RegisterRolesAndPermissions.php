<?php


namespace Tests\Traits;


use App\Models\Role;
use Bouncer;
use Database\Seeders\BouncerSeeder;
use Database\Seeders\DatabaseSeeder;

trait RegisterRolesAndPermissions
{
    public function registerRolesAndPermissions()
    {
        Bouncer::allow('super-admin')->everything();

        Role::create(['name' => 'user']);
        Role::create(['name' => 'seller']);
        Role::create(['name' => 'admin']);

        app(DatabaseSeeder::class)->call(BouncerSeeder::class);
    }
}
