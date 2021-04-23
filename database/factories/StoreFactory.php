<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'legal_name' => $this->faker->regexify('[A-Za-z0-9]{80}'),
            'legal_id' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'story' => $this->faker->city,
            'logo' => $this->faker->imageUrl(250, 250),
            'cover' => $this->faker->word,
            'team' => $this->faker->word,
            'active' => $this->faker->boolean,
        ];
    }
}
