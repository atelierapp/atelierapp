<?php

namespace Tests\Feature\Collection;

use Tests\TestCase;

class CollectionControllerCreateTest extends TestCase
{
    public function test_a_guess_cannot_create_any_collection()
    {
        $response = $this->postJson(route('collection.store'), []);

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_create_any_collection()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('collection.store'), []);

        $response->assertStatus(403);
    }

    public function test_an_authenticated_seller_can_create_a_collection()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
        ];
        $response = $this->postJson(route('collection.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
        $this->assertDatabaseHas('collections', $data);
    }

    public function test_an_authenticated_admin_can_create_a_collection()
    {
        $this->createAuthenticatedAdmin();

        $data = [
            'name' => $this->faker->name,
        ];
        $response = $this->postJson(route('collection.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
        $this->assertDatabaseHas('collections', $data);
    }
}
