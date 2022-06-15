<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\MediaType;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

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
        $model = $this->faker->randomElement([Product::class, Project::class]);

        return [
            'type_id' => MediaType::factory(),
            'mediable_type' => $model,
            'mediable_id' => $model::factory(),
            'featured' => $this->faker->boolean(40),
            'url' => $this->faker->url,
            'orientation' => $this->faker->word,
            'extra' => null,
        ];
    }

    public function model(Model $model)
    {
        return $this->state(function (array $attributes) use ($model) {
            return [
                'mediable_type' => get_class($model),
                'mediable_id' => $model->id,
            ];
        });
    }
}
