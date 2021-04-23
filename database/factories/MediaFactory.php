<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Media;
use App\Models\MediaType;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'type_id' => MediaType::factory(),
            'url' => $this->faker->url,
            'properties' => '{}',
            'main' => $this->faker->boolean,
        ];
    }
}
