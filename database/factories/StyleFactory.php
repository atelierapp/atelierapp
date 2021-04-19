<?php

namespace Database\Factories;

/** @var Factory $factory */

use App\Models\Style;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Style::class, function (Faker $faker) {
    return [
        'code' => $faker->numerify('ST####'),
        'name' => \Illuminate\Support\Str::ucfirst($faker->word),
    ];
});
