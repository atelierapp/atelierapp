<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @testdox Login
 */
class LoginTest extends TestCase
{

    /**
     * @test
     * @title Successful login
     * @description A user can access the app with a correct email/password.
     */
    public function a_user_can_access_the_app_with_a_correct_email_password()
    {
        $credentials = [
            'username' => 'mesut@ozil.com',
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

    /**
     * @test
     * @title Failed login
     * @description  A user can't access without a valid account
     *
     */
    public function a_user_cannot_access_without_a_valid_account(): void
    {
        $this->markTestIncomplete();
    }
}
