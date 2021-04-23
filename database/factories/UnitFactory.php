<?php

namespace Database\Factories;

use App\Models\Unit;
use App\Models\UnitSystem;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'class' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'factor' => $this->faker->randomFloat(9, 0, 999.999999999),
            'unit_system_id' => UnitSystem::factory(),
        ];
    }
}
