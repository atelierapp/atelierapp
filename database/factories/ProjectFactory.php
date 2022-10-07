<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Style;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'style_id' => Style::factory(),
            'author_id' => User::factory(),
            'forked_from_id' => $this->faker->randomElement([null, Project::factory()]),
            'published' => $this->faker->boolean,
            'public' => $this->faker->boolean,
            'country' => $this->faker->randomElement(['us', 'pe']),
        ];
    }

    public function us()
    {
        return $this->state(function (array $attributes) {
            return [
                'country' => 'us',
            ];
        });
    }

    public function pe()
    {
        return $this->state(function (array $attributes) {
            return [
                'country' => 'pe',
            ];
        });
    }

}
