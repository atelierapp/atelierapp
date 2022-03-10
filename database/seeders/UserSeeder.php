<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Bouncer;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database Seeders.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate([
            'email' => 'kenny@qbklabs.com',
        ], [
            'first_name' => 'Kenny',
            'last_name' => 'Horna',
            'username' => 'kenny',
            'password' => 'password',
            'phone' => '987654321',
            'birthday' => '1980-01-01',
        ]);
        Bouncer::assign(Role::ADMIN)->to($user);
        $user = User::updateOrCreate([
            'email' => 'jaime.virruetaf@gmail.com',
        ], [
            'first_name' => 'Jaime',
            'last_name' => 'Virrueta',
            'username' => 'jaime',
            'password' => 'password',
            'phone' => '987206134',
            'birthday' => '1980-01-01',
        ]);
        Bouncer::assign(Role::ADMIN)->to($user);

        User::updateOrCreate([
            'email' => 'john@doe.com',
        ], [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'johndoe',
            'password' => 'password',
            'phone' => '987654321',
            'birthday' => '1980-01-01',
        ]);
    }
}
