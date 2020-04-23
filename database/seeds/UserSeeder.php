<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\Models\User::class)->create([
            'first_name' => 'Kenny',
            'last_name'  => 'Horna',
            'email'      => 'kenny@qbklabs.com',
            'username'   => 'kenny',
            'password'   => 'Mis3cretP@ss',
        ]);

        $user->assignRole('admin');
    }
}
