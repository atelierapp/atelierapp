<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Traits\Factories\CountryStateTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    use CountryStateTrait;

    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'active' => $this->faker->boolean,
            'country' => config('app.country'),
        ];
    }
}
