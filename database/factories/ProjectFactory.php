<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Style;
use App\Models\User;
use Database\Factories\Traits\CountryStateTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    use CountryStateTrait;

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
            'country' => config('app.country'),
        ];
    }
}
