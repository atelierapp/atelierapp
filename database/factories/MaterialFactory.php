<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Material;

class MaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Material::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => substr($this->faker->name, 0, 20),
            'image' => $this->faker->imageUrl(500, 500),
            'active' => $this->faker->boolean,
        ];
    }
}
