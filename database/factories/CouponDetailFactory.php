<?php

namespace Database\Factories;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'coupon_id' => Coupon::factory()->allActive(),
            'model_type' => $this->faker->randomElement([
                Product::class,
                User::class
            ]),
        ];
    }

    public function product(int $productId): static
    {
        return $this->state(fn () => [
            'model_type' => Product::class,
            'model_id' => $productId,
        ]);
    }

    public function user(int $userId): static
    {
        return $this->state(fn () => [
            'model_type' => User::class,
            'model_id' => $userId,
        ]);
    }

}
