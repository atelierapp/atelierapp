<?php

namespace Profile;

use Tests\TestCase;

use function route;

class UpdateProfileTest extends TestCase
{
    public function test_a_guess_user_cannot_update_profile()
    {
        $response = $this->getJson(route('profile.update'));

        $response->assertStatus(401);
    }

    public function test_an_authenticated_seller_user_can_update_his_profile()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->numerify('#########'),
            'birthday' => $this->faker->date(),
        ];
        $response = $this->patchJson(route('profile.update'), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(['data' => [
            'id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'birthday',
            'avatar',
            'is_active',
        ]]);
        $this->assertEquals($data['first_name'], $response->json('data.first_name'));
        $this->assertEquals($data['last_name'], $response->json('data.last_name'));
        $this->assertEquals($data['email'], $response->json('data.email'));
        $this->assertEquals($data['phone'], $response->json('data.phone'));
    }
}
