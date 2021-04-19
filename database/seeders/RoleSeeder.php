<?php

namespace Database\seeders;

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
        Role::create(['name' => Role::USER]);
        Role::create(['name' => Role::SELLER]);
        Role::create(['name' => Role::ADMIN]);
    }
}
