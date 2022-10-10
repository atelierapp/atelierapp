<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Bouncer;
use Illuminate\Database\Seeder;

class UserPeSeeder extends Seeder
{
    /**
     * Run the database Seeders.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::updateOrCreate(['email' => 'admin-pe@atelier.com'], [
            'first_name' => 'Admin',
            'last_name' => 'Atelier',
            'password' => 'password',
            'phone' => '987654321',
            'birthday' => '1990-01-01',
            'country' => 'pe',
            'locale' => 'es',
        ]);
        Bouncer::assign(Role::ADMIN)->to($user);

        $user = User::updateOrCreate(['email' => 'seller-pe@atelier.com'], [
            'first_name' => 'Seller',
            'last_name' => 'Atelier',
            'password' => 'password',
            'phone' => '987654321',
            'birthday' => '1990-01-01',
            'country' => 'pe',
            'locale' => 'es',
        ]);
        Bouncer::assign(Role::SELLER)->to($user);

        $user = User::updateOrCreate(['email' => 'user-pe@atelier.com'], [
            'first_name' => 'AppUser',
            'last_name' => 'Atelier',
            'password' => 'password',
            'phone' => '987654321',
            'birthday' => '1990-01-01',
            'country' => 'pe',
            'locale' => 'es',
        ]);
        Bouncer::assign(Role::USER)->to($user);
    }
}
