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
        $user = User::updateOrCreate(['email' => 'kenny@qbklabs.com',], [
            'country' => 'us',
            'locale' => 'en',
            'first_name' => 'Kenny',
            'last_name' => 'Horna',
            'password' => 'password',
            'phone' => '987654321',
            'birthday' => '1980-01-01',
        ]);
        Bouncer::assign(Role::ADMIN)->to($user);

        $user = User::updateOrCreate(['email' => 'jaime.virruetaf@gmail.com',], [
            'country' => 'us',
            'locale' => 'en',
            'first_name' => 'Jaime',
            'last_name' => 'Virrueta',
            'password' => 'password',
            'phone' => '987206134',
            'birthday' => '1980-01-01',
        ]);
        Bouncer::assign(Role::ADMIN)->to($user);

        $user = User::updateOrCreate(['email' => 'seller@atelier.com',], [
            'country' => 'us',
            'locale' => 'en',
            'first_name' => 'Seller',
            'last_name' => 'Atelier',
            'password' => 'password',
            'phone' => '987654321',
            'birthday' => '1990-01-01',
        ]);
        Bouncer::assign(Role::SELLER)->to($user);

        $user = User::updateOrCreate(['email' => 'user@atelier.com',], [
            'country' => 'us',
            'locale' => 'en',
            'first_name' => 'AppUser',
            'last_name' => 'Atelier',
            'password' => 'password',
            'phone' => '987654321',
            'birthday' => '1990-01-01',
        ]);
        Bouncer::assign(Role::USER)->to($user);

        User::updateOrCreate(['email' => 'john@doe.com',], [
            'country' => 'us',
            'locale' => 'en',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => 'password',
            'phone' => '987654321',
            'birthday' => '1980-01-01',
        ]);
    }
}
