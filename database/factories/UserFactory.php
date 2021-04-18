<?php

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Carbon;

/** @var Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->unique()->userName,
        'password' => 'MiPassword@',
        'phone' => $faker->numerify('9########'),
//        'birthday'   => $faker->date(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});

$factory->afterCreating(User::class, function (User $user, $faker) {
    Bouncer::assign('user')->to($user);
});

$factory->afterCreatingState(User::class, 'admin', function (User $user, $faker) {
    Bouncer::assign('admin')->to($user);
});
