<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Database\Factories\Traits\CountryStateTrait;
use Database\Factories\Traits\ActiveState;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    use ActiveState;
    use CountryStateTrait;

    protected $model = Store::class;

    public function definition(): array
    {
        return [
            'country' => config('app.country'),
            'user_id' => User::factory(),
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
}
