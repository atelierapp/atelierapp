<?php

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->unique()->safeEmail,
        'password'   => 'MiPassword@',
        'phone'      => $faker->numerify('9########'),
//        'birthday'   => $faker->date(),
        'avatar'     => $faker->imageUrl(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
