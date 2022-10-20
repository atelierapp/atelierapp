<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\PaymentStatus;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country' => config('app.country'),
            'order_id' => Order::factory(),
            'user_id' => User::factory(),
            'store_id' => Store::factory(),
            'seller_id' => User::factory(),
            'items' => $this->faker->numberBetween(1,5),
            'total_price' => $this->faker->numberBetween(10000, 50000) / 100,
            'paid_status_id' => $this->faker->randomElement([
                PaymentStatus::PAYMENT_PENDING,
                PaymentStatus::PAYMENT_APPROVAL,
                PaymentStatus::PAYMENT_REJECT,
            ])
        ];
    }
}
