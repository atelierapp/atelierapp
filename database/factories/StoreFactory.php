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
            'name' => $this->faker->company,
            'legal_name' => sprintf("%s %s", $this->faker->company, $this->faker->companySuffix),
            'legal_id' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'story' => $this->faker->text('120'),
            'logo' => $this->faker->imageUrl(250, 250),
            'cover' => $this->faker->imageUrl(250, 250),
            'team' => $this->faker->word,
            'active' => $this->faker->boolean,
        ];
    }
}
