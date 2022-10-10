<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use Tests\TestCase;

class StoreUserQualifyControllerTest extends TestCase
{
    public function test_a_guest_user_cannot_submit_any_store_qualification()
    {
        $response = $this->postJson(route('store.qualify', 1));

        $response->assertUnauthorized();
    }

    public function test_an_user_cannot_qualify_a_store_without_score_param()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('store.qualify', 1), [], $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['score']);
    }

    public function test_an_user_cannot_qualify_a_store_if_value_of_score_param_is_a_string()
    {
        $this->createAuthenticatedUser();

        $data = [
            'score' => $this->faker->word ,
        ];
        $response = $this->postJson(route('store.qualify', 1), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['score']);
    }

    public function test_an_user_cannot_qualify_a_store_if_value_of_score_param_is_zero()
    {
        $this->createAuthenticatedUser();

        $data = [
            'score' => 0,
        ];
        $response = $this->postJson(route('store.qualify', 1), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['score']);
    }

    public function test_an_user_cannot_qualify_a_store_if_value_is_greatest_than_five()
    {
        $this->createAuthenticatedUser();

        $data = [
            'score' => 8,
        ];
        $response = $this->postJson(route('store.qualify', 1), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['score']);
    }

    public function test_an_user_can_qualify_a_store_with_valid_params()
    {
        $this->createAuthenticatedUser();
        $store = Store::factory()->create();

        $data = [
            'score' => 4,
            'comment' => $this->faker->paragraph
        ];
        $response = $this->postJson(route('store.qualify', $store->id), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'score',
                'comment'
            ]
        ]);
        self::assertEquals($data['score'], $response->json('data.score'));
        self::assertEquals($data['comment'], $response->json('data.comment'));
        self::assertDatabaseCount('store_user_ratings', 1);
    }
}
