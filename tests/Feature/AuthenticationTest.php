<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationTest extends TestCase {

    /** @test */
    public function a_user_can_access_the_apps_with_a_correct_email_password()
    {
        $credentials = [
            'email' => 'mesut@ozil.com',
            'password' => 'TheChosenOne',
        ];
        $user = $this->createUser($credentials);
        $response = $this->postJson('/api/login', $credentials);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => ['access_token'],
            ]);
    }
}
