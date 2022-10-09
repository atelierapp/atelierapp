<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Material;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition(): array
    {
        return [
            'name' => substr($this->faker->name, 0, 20),
            'image' => $this->faker->imageUrl(500, 500),
            'active' => $this->faker->boolean,
        ];
    }
}
