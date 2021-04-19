<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {

    /**
     * Run the database Seeders.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'user']);
        Role::create(['name' => 'seller']);
        Role::create(['name' => 'admin']);
    }
}
