<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    public function definition(): array
    {
        $values = [
            'order_id' => Order::factory(),
            'product_id' => $product = Product::factory(),
            'variation_id' => Variation::factory(['product_id' => $product]),
            'unit_price' => $this->faker->numberBetween(1000, 10000) / 100,
            'quantity' => $this->faker->numberBetween(1,5),
        ];

        $values['total_price'] = $values['unit_price'] * $values['quantity'];

        return $values;
    }
}
