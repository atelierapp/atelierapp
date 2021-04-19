<?php

namespace Database\seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Bouncer;

class UserSeeder extends Seeder {

    /**
     * Run the database Seeders.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'first_name' => 'Kenny',
            'last_name'  => 'Horna',
            'email'      => 'kenny@qbklabs.com',
            'username'   => 'kenny',
            'password'   => 'Mis3cretP@ss',
        ]);
        Bouncer::assign(Role::ADMIN)->to($user);

        User::factory()->create(['email' => 'john@doe.com']);
    }
}
