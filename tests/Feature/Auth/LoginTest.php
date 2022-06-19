<?php

namespace Tests\Feature\Auth;

use App\Services\SocialService;
use Tests\TestCase;

use function route;

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
            'email' => 'mesut@ozil.com',
            'password' => 'TheChosenOne',
        ];

        $this->createUser($credentials);

        $response = $this->postJson('/api/login', $credentials);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => ['access_token'],
            ]);
    }

    /**
     * @test
     * @title Successful login with Facebook
     * @description A user can access the app with a Facebook account.
     */
    public function a_user_can_access_the_app_with_a_facebook_account()
    {
        $socialMock = \Mockery::mock(SocialService::class);
        $socialMock->shouldReceive('getDetailsFromDriver')
            ->once()
            ->with('facebook', $socialToken = 'an-access-token-from-facebook')
            ->andReturn((object)[
                'social_id' => $socialId = 'facebook-social-id',
                'email' => $email = 'john@doe.com',
                'avatar' => 'https://imageurl.com',
                'first_name' => $firstName = 'John',
                'last_name' => $lastName = 'Doe',
            ]);
        $user = $this->createUser([
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);
        $socialMock->shouldReceive('getUser')->once()->with($socialId)->andReturn($user);
        $this->app->bind(SocialService::class, fn() => $socialMock);

        $credentials = [
            'social_driver' => 'facebook',
            'social_token' => $socialToken,
        ];

        $response = $this->postJson('/api/login-social', $credentials);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => ['access_token'],
            ]);
    }

    /**
     * @test
     * @title Successful login with Apple
     * @description A user can access the app with an Apple account.
     */
    public function a_user_can_access_the_app_with_an_apple_account()
    {
        $socialMock = \Mockery::mock(SocialService::class);
        $socialMock->shouldReceive('getDetailsFromDriver')
            ->once()
            ->with('apple', $socialToken = 'an-access-token-from-apple')
            ->andReturn((object)[
                'social_id' => $socialId = 'apple-social-id',
                'email' => $email = 'john@doe.com',
                'last_name' => $lastName = '',
            ]);
        $user = $this->createUser([
            'email' => $email,
            'last_name' => $lastName,
        ]);
        $socialMock->shouldReceive('getUser')->once()->with($socialId)->andReturn($user);
        $this->app->bind(SocialService::class, fn() => $socialMock);

        $credentials = [
            'social_driver' => 'apple',
            'social_token' => $socialToken,
        ];

        $response = $this->postJson('/api/login-social', $credentials);

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
        $credentials = [
            'email' => $email = 'mesut@ozil.com',
            'password' => 'wrong-password',
        ];
        $this->createUser([
            'email' => $email,
        ]);

        $response = $this->postJson(route('login'), $credentials);

        $response
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);
    }
}
