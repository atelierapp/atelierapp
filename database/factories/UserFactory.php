<?php

namespace Database\Factories;

use App\Models\User;
use Bouncer;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'phone' => $this->faker->numerify('9########'),
            'birthday' => $this->faker->dateTimeBetween('-50 years', '-18 years'),
        ];
    }

    public function withRoles($roles): UserFactory
    {
        if (empty($roles)) {
            return $this;
        }

        return $this->afterCreating(
            function (User $user) use ($roles) {
                Bouncer::assign($roles)->to($user);
            }
        );
    }
}
