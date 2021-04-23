<?php

namespace Database\Factories;

use App\Models\Style;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StyleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Style::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->numerify('ST####'),
            'name' => Str::ucfirst($this->faker->word),
        ];
    }
}
