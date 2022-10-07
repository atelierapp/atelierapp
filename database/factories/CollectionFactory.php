<?php

namespace Database\Factories;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Collection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'is_featured' => $this->faker->boolean,
            'country' => $this->faker->randomElement(['us', 'pe']),
        ];
    }

    public function us()
    {
        return $this->state(function (array $attributes) {
            return [
                'country' => 'us',
            ];
        });
    }

    public function pe()
    {
        return $this->state(function (array $attributes) {
            return [
                'country' => 'pe',
            ];
        });
    }
}
