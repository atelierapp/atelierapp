<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
            'first_name' => 'Kenny',
            'last_name'  => 'Horna',
            'email'      => 'kenny@qbklabs.com',
            'username'   => 'kenny',
            'password'   => 'Mis3cretP@ss',
        ]);

        Bouncer::assign(Role::ADMIN)->to($user);

        factory(User::class)->create(['email' => 'john@doe.com']);
    }
}
