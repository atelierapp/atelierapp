<?php

namespace Database\Factories;

use App\Models\User;
use Bouncer;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => 'MiPassword@',
            'phone' => $this->faker->numerify('9########'),
            'birthday' => $this->faker->dateTimeBetween('-50 years', '-18 years'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
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

    public function configure(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(Role::USER);
        });
    }
}
