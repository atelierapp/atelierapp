<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Variation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'product_id' => Product::factory(),
            'is_duplicated' => $this->faker->boolean,
            'country' => $this->faker->randomElement(['us', 'pe']),
        ];
    }
}
