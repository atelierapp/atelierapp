<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShoppingCartFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country' => config('app.country'),
            'customer_type' => User::class,
            'customer_id' => User::factory(),
            'variation_id' => Variation::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }

    public function product(Product $product): ShoppingCartFactory
    {
        return $this->state(fn () => [
            'variation_id' => Variation::factory(['product_id' => $product->id]),
        ]);
    }
}
