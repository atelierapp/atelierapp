<?php

/** @var Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => $faker->url,
        'parent_id' => null,
        'active' => $faker->boolean,
    ];
});
