<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'order' => $this->faker->numberBetween(1, 100),
            'segment' => $this->faker->country,
            'type' => $this->faker->randomElement([Banner::TYPE_POPUP, Banner::TYPE_CAROUSEL]),
        ];
    }
}
