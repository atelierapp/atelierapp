<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Style;
use Faker\Generator as Faker;

$factory->define(Style::class, function (Faker $faker) {
    return [
        'code' => $faker->numerify('ST####'),
        'name' => \Illuminate\Support\Str::ucfirst($faker->word),
    ];
});
