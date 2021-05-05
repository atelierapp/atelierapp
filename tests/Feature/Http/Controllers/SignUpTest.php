<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

/**
 * @testdox Registration
 */
class SignUpTest extends TestCase
{

    use WithFaker;

    /**
     * @test
     * @title Successful registration
     * @description An account can be created with valid data.
     */
    public function an_account_can_be_created_with_valid_data()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'username' => $this->faker->userName,
            'phone' => $this->faker->numerify('9########'),
            'password' => 'P4as.sword'
        ];

        $response = $this->postJson(route('signUp'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'username',
                    'phone',
                    'birthday',
                    'avatar',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
                'access_token',
            ]
        ]);
    }

    /**
     * @test
     * @title Successful registration with social account
     * @description An account can be created with valid data linking the social account.
     */
    public function an_account_can_be_created_with_valid_data_linking_the_social_account()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_invalid_data(): void
    {
        $response = $this->postJson(route('signUp'));

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'first_name',
                'email',
                'username',
                'password'
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_short_first_name(): void
    {
        $data = [
            'first_name' => 'a',
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'username' => $this->faker->streetName,
            'phone' => $this->faker->numerify('9########'),
            'password' => 'P4as.sword'
        ];

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'first_name',
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_long_first_name(): void
    {
        $data = [
            'first_name' => $this->faker->text(),
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'username' => $this->faker->streetName,
            'phone' => $this->faker->numerify('9########'),
            'password' => 'P4as.sword'
        ];

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'first_name',
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_short_last_name(): void
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => 'a',
            'email' => $this->faker->safeEmail,
            'username' => $this->faker->streetName,
            'phone' => $this->faker->numerify('9########'),
            'password' => 'P4as.sword'
        ];

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'last_name',
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_long_last_name(): void
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->paragraphs(6),
            'email' => $this->faker->safeEmail,
            'username' => $this->faker->streetName,
            'phone' => $this->faker->numerify('9########'),
            'password' => 'P4as.sword'
        ];

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'last_name',
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_existing_email(): void
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'username' => $this->faker->streetName,
            'phone' => $this->faker->numerify('9########'),
            'password' => 'P4as.sword'
        ];
        User::factory()->create(['email' => $data['email']]);

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'email',
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_invalid_email(): void
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => 'invalidmail',
            'username' => $this->faker->streetName,
            'phone' => $this->faker->numerify('9########'),
            'password' => 'P4as.sword'
        ];

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'email',
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_username_less_than_3_characters(): void
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'username' => 'us',
            'phone' => $this->faker->numerify('9########'),
            'password' => 'P4as.sword'
        ];

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'username',
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_existing_username(): void
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'username' => $this->faker->text(10),
            'phone' => $this->faker->numerify('9########'),
            'password' => 'P4as.sword'
        ];
        User::factory()->create(['username' => $data['username']]);

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'username',
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_phone_less_than_7_digits(): void
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'username' => $this->faker->text(10),
            'phone' => $this->faker->numerify('######'),
            'password' => 'P4as.sword'
        ];

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'phone',
            ]
        ]);
    }

    /**
     * @test
     * @title Invalid registration
     * @description An account can't be create with invalid data.
     */
    public function an_account_cannot_be_create_with_phone_more_than_14_digits(): void
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'username' => $this->faker->text(10),
            'phone' => $this->faker->numerify('####################'),
            'password' => 'P4as.sword'
        ];

        $response = $this->postJson(route('signUp'), $data);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'phone',
            ]
        ]);
    }

}
