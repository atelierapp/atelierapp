<?php

namespace Database\Factories;

use App\Models\Style;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StyleFactory extends Factory
{
    protected $model = Style::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->numerify('ST####'),
            'name' => Str::ucfirst($this->faker->word),
        ];
    }
}
