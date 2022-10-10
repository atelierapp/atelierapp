<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variation;
use App\Traits\Factories\CountryStateTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariationFactory extends Factory
{
    use CountryStateTrait;

    protected $model = Variation::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'product_id' => Product::factory()->country(),
            'is_duplicated' => $this->faker->boolean,
            'country' => $this->faker->randomElement(['us', 'pe']),
        ];
    }
}
