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
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'legal_name' => $this->faker->word,
            'legal_id' => $this->faker->lexify('?????????'),
            'story' => $this->faker->sentence(5),
            'logo' => $this->faker->url,
            'cover' => $this->faker->url,
            'team' => $this->faker->url,
            'active' => true,
        ];
    }
}
