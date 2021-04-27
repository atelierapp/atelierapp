<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $model = $this->faker->randomElement([Product::class, Project::class]);

        return [
            'name' => $this->faker->name,
            'active' => $this->faker->boolean,
            'taggable_type' => $model,
            'taggable_id' => $model::factory(),
        ];
    }
}
