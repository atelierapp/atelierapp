<?php

namespace Database\Factories;

use App\Models\Banner;
use App\Traits\Factories\CountryStateTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    use CountryStateTrait;

    protected $model = Banner::class;

    public function definition(): array
    {
        return [
            'country' => config('app.country'),
            'name' => $this->faker->name,
            'order' => $this->faker->numberBetween(1, 100),
            'segment' => $this->faker->country,
            'type' => $this->faker->randomElement([Banner::TYPE_POPUP, Banner::TYPE_CAROUSEL]),
        ];
    }
}
