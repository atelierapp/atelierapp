<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'variation_id' => $variation = Variation::factory()->create(),
            'product_id' => $variation->product_id,
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }
}
