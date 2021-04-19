<?php

namespace Database\Factories;

/** @var Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'manufacturer_type' => 'store',
        'manufactured_at' => $faker->date(),
        'description' => $faker->text,
        'category_id' => factory(\App\Models\Category::class),
        'price' => $faker->randomNumber(),
        'quantity' => $faker->randomNumber(),
        'sku' => $faker->lexify('???????????'),
        'store_id' => factory(\App\Models\Store::class),
        'active' => $faker->boolean,
        'properties' => [],
    ];
});
