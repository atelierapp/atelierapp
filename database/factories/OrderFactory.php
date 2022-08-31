<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $values = [
            'user_id' => User::factory(),
            'store_id' => Store::factory(),
            'seller_id' => User::factory(),
            'seller_status_id' => $this->faker->randomElement([Order::SELLER_PENDING, Order::SELLER_APPROVAL, Order::SELLER_REJECT]),
            'seller_status_at' => $this->faker->dateTimeBetween('-30 days'),
            'unit_price' => $this->faker->numberBetween(1000, 10000) / 100,
            'items' => $this->faker->numberBetween(1,5),
        ];

        $values['total_price'] = $values['unit_price'] * $values['items'];

        return $values;
    }

    public function sellerPending(): OrderFactory
    {
        return $this->state(function () {
            return [
                'seller_status_id' => Order::SELLER_PENDING,
            ];
        });
    }

    public function sellerApproved(): OrderFactory
    {
        return $this->state(function () {
            return [
                'seller_status_id' => Order::SELLER_APPROVAL,
            ];
        });
    }

    public function withParent(): OrderFactory
    {
        return $this->state(function () {
            return [
                'parent_id' => Order::factory(),
            ];
        });
    }
}
