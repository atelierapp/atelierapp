<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
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
}
