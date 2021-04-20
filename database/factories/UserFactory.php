<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Bouncer;

class UserFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
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

    public function withAdminRole()
    {
        return $this->afterCreating(function (User $user) {
            Bouncer::assign(Role::ADMIN)->to($user);
        });
    }

    public function withUserRole()
    {
        return $this->afterCreating(function (User $user) {
            Bouncer::assign(Role::USER)->to($user);
        });
    }
}
