<?php

namespace Database\Factories;

use App\Models\Collection;
use App\Traits\Factories\CountryStateTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    use CountryStateTrait;

    protected $model = Collection::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'is_featured' => $this->faker->boolean,
            'country' => $this->faker->randomElement(['us', 'pe']),
        ];
    }
}
