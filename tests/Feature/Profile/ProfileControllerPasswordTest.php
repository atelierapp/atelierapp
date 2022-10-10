<?php

namespace Tests\Feature\Profile;

use Tests\TestCase;

class ProfileControllerPasswordTest extends TestCase
{
    public function test_an_guess_user_cannot_change_password()
    {
        $response = $this->postJson(route('profile.change-password'), [], $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_user_cannot_change_password_without_params()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('profile.change-password'), [], $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'old_password',
            'password',
        ]);
    }

    public function test_an_user_cannot_change_password_with_invalid_old_password()
    {
        $this->createAuthenticatedUser(['password' => 'fail_password']);

        $data = [
            'old_password' => 'old_password',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->postJson(route('profile.change-password'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'code',
            'message',
            'errors',
        ]);
    }

    public function test_an_user_cannot_change_password_with_when_password_dont_match()
    {
        $this->createAuthenticatedUser(['password' => 'old_password']);

        $data = [
            'old_password' => 'old_password',
            'password' => 'password',
            'password_confirmation' => 'password1',
        ];
        $response = $this->postJson(route('profile.change-password'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'password',
        ]);
    }

    public function test_an_user_can_change_password_with_all_valid_params()
    {
        $this->createAuthenticatedUser(['password' => 'old_password']);

        $data = [
            'old_password' => 'old_password',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->postJson(route('profile.change-password'), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'message',
            ],
        ]);
    }
}
