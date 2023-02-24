<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Variation;
use Database\Factories\Traits\CountryStateTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    use CountryStateTrait;

    public function definition(): array
    {
        $values = [
            'country' => config('app.country'),
            'order_id' => Order::factory(),
            'product_id' => $product = Product::factory(),
            'variation_id' => Variation::factory(['product_id' => $product]),
            'unit_price' => $this->faker->numberBetween(1000, 10000) / 100,
            'quantity' => $this->faker->numberBetween(1,5),
            'seller_status_id' => $this->faker->randomElement([OrderStatus::_SELLER_PENDING, OrderStatus::_SELLER_APPROVAL, OrderStatus::_SELLER_REJECT]),
            'seller_status_at' => $this->faker->dateTimeBetween('-30 days'),
            'seller_notes' => $this->faker->randomElement([null, $this->faker->paragraph]),
        ];

        $values['total_price'] = $values['unit_price'] * $values['quantity'];

        return $values;
    }

    public function sellerPending(): OrderDetailFactory
    {
        return $this->state(function () {
            return [
                'seller_status_id' => OrderStatus::_SELLER_PENDING,
            ];
        });
    }
}
