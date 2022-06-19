<?php

namespace Tests\Feature\Collection;

use App\Models\Collection;
use Tests\TestCase;

class CollectionControllerUpdateTest extends TestCase
{
    public function test_a_guess_cannot_update_any_collection()
    {
        $response = $this->patchJson(route('collection.update', 1), []);

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_update_any_collection()
    {
        $this->createAuthenticatedUser();

        $response = $this->patchJson(route('collection.update', 1), []);

        $response->assertStatus(403);
    }

    public function test_an_authenticated_seller_can_update_any_collection()
    {
        $user = $this->createAuthenticatedSeller();
        $collection = Collection::factory()->create(['user_id' => $user->id]);

        $data = [
            'name' => $this->faker->name,
        ];
        $response = $this->patchJson(route('collection.update', $collection->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'is_active',
            ],
        ]);
        $this->assertDatabaseHas('collections', $data);
    }

    public function test_an_authenticated_admin_can_update_any_collection()
    {
        $user = $this->createAuthenticatedSeller();
        $collection = Collection::factory()->create(['user_id' => $user->id]);

        $data = [
            'name' => $this->faker->name,
        ];
        $response = $this->patchJson(route('collection.update', $collection->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'is_active',
            ],
        ]);
        $this->assertDatabaseHas('collections', $data);
    }

    public function test_an_authenticated_admin_can_update_to_inactive_any_collection()
    {
        $user = $this->createAuthenticatedSeller();
        $collection = Collection::factory()->create(['user_id' => $user->id, 'is_active' => true]);

        $data = [
            'name' => $this->faker->name,
            'is_active' => false,
        ];
        $response = $this->patchJson(route('collection.update', $collection->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'is_active',
            ],
        ]);
        $this->assertDatabaseHas('collections', $data);
    }
}
