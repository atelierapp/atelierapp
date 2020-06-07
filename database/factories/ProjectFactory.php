<?php

/** @var Factory $factory */

use App\Models\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'style_id' => factory(\App\Models\Style::class),
        'author_id' => factory(\App\Models\User::class),
        'forked_from' => factory(\App\Models\Project::class),
        'published' => $faker->boolean,
        'public' => $faker->boolean,
    ];
});
