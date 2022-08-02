<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::updateOrCreate(['name' => 'user']);
        Role::updateOrCreate(['name' => 'seller']);
        Role::updateOrCreate(['name' => 'admin']);
    }
}
