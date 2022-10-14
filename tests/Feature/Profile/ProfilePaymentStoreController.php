<?php

namespace Tests\Feature\Profile;

use Tests\TestCase;

class ProfilePaymentStoreController extends TestCase
{
    public function test_a_guess_user_cannot_store_any_payment_gateway()
    {
        $response = $this->postJson(route('profile.payment-gateway.store'));

        $response->assertUnauthorized();
    }

    public function test_an_authenticated_seller_user_cannot_store_a_payment_gateway_without_params()
    {
        $this->createAuthenticatedSeller();

        $data = [

        ];
        $response = $this->postJson(route('profile.payment-gateway.store'), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'payment_gateway_id',
        ]);
    }

    public function test_an_authenticated_seller_user_cannot_store_a_payment_gateway_without_email_when_gateway_is_paypal()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'payment_gateway_id' => 1
        ];
        $response = $this->postJson(route('profile.payment-gateway.store'), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'email'
        ]);
    }

    public function test_an_authenticated_seller_can_store_a_paypal_payment_gateway_with_valid_params()
    {
        $user = $this->createAuthenticatedSeller();

        $data = [
            'payment_gateway_id' => 1,
            'email' => $this->faker->email,
        ];
        $response = $this->postJson(route('profile.payment-gateway.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'user',
                'payment_gateway' => [
                    'id',
                    'name'
                ],
                'properties' => [
                    'email'
                ]
            ],
        ]);
        $this->assertDatabaseHas('payment_gateway_user', [
            'user_id' => $user->id,
            'payment_gateway_id' => 1,
            'properties->email' => $data['email']
        ]);
    }

    public function test_an_authenticated_app_user_cannot_store_any_payment_gateway()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('profile.payment-gateway.store'));

        $response->assertUnauthorized();
    }
}
