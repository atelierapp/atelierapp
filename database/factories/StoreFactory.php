<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'country' => $user->country,
            'user_id' => $user->id,
            'name' => $this->faker->company,
            // 'legal_name' => sprintf("%s %s", $this->faker->company, $this->faker->companySuffix),
            // 'legal_id' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'story' => $this->faker->text('120'),
            'logo' => $this->faker->imageUrl(250, 250),
            'cover' => $this->faker->imageUrl(250, 250),
            'team' => $this->faker->word,
            'active' => $this->faker->boolean,
            'customer_rating' => rand(30, 50) / 10,
            'internal_rating' => rand(30, 50) / 10,
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
