<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Style;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'style_id' => Style::factory(),
            'author_id' => User::factory(),
            'forked_from_id' => $this->faker->randomElement([null, Project::factory()]),
            'published' => $this->faker->boolean,
            'public' => $this->faker->boolean,
        ];
    }
}
