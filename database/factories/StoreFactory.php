<?php

namespace Database\Factories;

/** @var Factory $factory */

use App\Models\Store;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Store::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'legal_name' => $faker->word,
        'legal_id' => $faker->lexify('?????????'),
        'story' => $faker->sentence(5),
        'logo' => $faker->url,
        'cover' => $faker->url,
        'team' => $faker->url,
        'active' => true,
    ];
});
