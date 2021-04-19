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
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'style_id' => Style::factory()->create()->id,
            'author_id' => User::factory()->create()->id,
            'published' => $this->faker->boolean,
            'public' => $this->faker->boolean,
        ];
    }
}
