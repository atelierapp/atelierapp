<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'user_id' => User::factory(),
            'store_id' => Store::factory(),
            'seller_id' => User::factory(),
            'items' => $this->faker->numberBetween(1,5),
            'total_price' => $this->faker->numberBetween(10000, 50000) / 100,
            'paid_status_id' => $this->faker->randomElement([
                Invoice::PAYMENT_PENDING,
                Invoice::PAYMENT_APPROVAL,
                Invoice::PAYMENT_REJECT,
            ])
        ];
    }
}
