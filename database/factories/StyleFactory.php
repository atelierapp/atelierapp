<?php

namespace Database\Factories;

use App\Models\Style;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition()
    {
        return [
            'code' => $this->faker->numerify('ST####'),
            'name' => \Illuminate\Support\Str::ucfirst($this->faker->word),
        ];
    }
}
