<?php

namespace Tests\Feature\Auth;

use App\Models\ForgotPassword;
use App\Models\User;
use Tests\TestCase;

class RecoverPasswordTest extends TestCase
{
    public function test_guest_user_cannot_recover_a_password_without_any_params()
    {
        $response = $this->postJson(route('resetPassword'));

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'token',
            'email',
            'password'
        ]);
    }

    public function test_guest_user_cannot_recover_a_password_with_invalid_token()
    {
        $forgotPassword = ForgotPassword::create([
            'email' => $this->faker->email,
            'token' => md5('token'),
        ]);

        $response = $this->postJson(route('resetPassword'), [
            'token' => 'some-token',
            'email' => $forgotPassword->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertUnprocessable();
    }

    public function test_guest_user_cannot_recover_a_password_with_invalid_email()
    {
        $forgotPassword = ForgotPassword::create([
            'email' => $this->faker->email,
            'token' => md5('token'),
        ]);

        $response = $this->postJson(route('resetPassword'), [
            'token' => $forgotPassword->token,
            'email' => $forgotPassword->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertUnprocessable();
    }

    public function test_guest_user_cannot_recover_a_password_with_invalid_password_confirmation()
    {
        $user = User::factory()->create();
        $forgotPassword = ForgotPassword::create([
            'email' => $user->email,
            'token' => md5('token'),
        ]);

        $response = $this->postJson(route('resetPassword'), [
            'token' => $forgotPassword->token,
            'email' => $forgotPassword->email,
            'password' => 'password',
            'password_confirmation' => 'invalid-password',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'password'
        ]);
    }

    public function test_guest_user_can_recover_a_password_with_valid_params_and_can_login_with_new_password()
    {
        $user = User::factory()->create();
        $forgotPassword = ForgotPassword::create([
            'email' => $user->email,
            'token' => md5('token'),
        ]);

        $response = $this->postJson(route('resetPassword'), [
            'token' => $forgotPassword->token,
            'email' => $forgotPassword->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertOk();

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertOk();
    }
}
