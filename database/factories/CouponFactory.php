<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('????-####'),
            'is_active' => $this->faker->boolean(90),
            'name' => $this->faker->unique()->name,
            'description' => $this->faker->paragraph,
            'start_date' => $start = $this->faker->dateTimeBetween('-30 days', '-10 days'),
            'end_date' => $this->faker->dateTimeBetween($start, '30 days'),
            'is_fixed' => $fixed = $this->faker->boolean,
            'amount' => $fixed ? $this->faker->numberBetween(10, 20) : $this->faker->numberBetween(20, 50),
            'max_uses' => $max = $this->faker->numberBetween(5, 10),
            'current_uses' => $this->faker->numberBetween(0, $max),
        ];
    }

    public function allActive(): CouponFactory
    {
        return $this->state(fn () => [
            'is_active' => true,
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonth(),
            'max_uses' => 999,
            'current_uses' => 1,
        ]);
    }

    public function fixed(int|float $amount): CouponFactory
    {
        return $this->state(fn () => [
            'is_fixed' => true,
            'amount' => $amount,
        ]);
    }

    public function percent(int|float $amount): CouponFactory
    {
        return $this->state(fn () => [
            'is_fixed' => false,
            'amount' => $amount,
        ]);
    }

    public function totalMode(int $storeId): CouponFactory
    {
        return $this->state(fn () => [
            'mode' => Coupon::MODE_TOTAL,
            'store_id' => null,
        ]);
    }

    public function sellerMode(int $storeId): CouponFactory
    {
        return $this->state(fn () => [
            'mode' => Coupon::MODE_SELLER,
            'store_id' => $storeId,
        ]);
    }

    public function productMode(int $storeId): CouponFactory
    {
        return $this->state(fn () => [
            'mode' => Coupon::MODE_PRODUCT,
            'store_id' => $storeId,
        ]);
    }
}
