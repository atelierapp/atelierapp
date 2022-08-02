<?php

namespace Tests\Feature\Collection;

use App\Models\Collection;
use Tests\TestCase;

class CollectionControllerDeleteTest extends TestCase
{
    public function test_a_guess_cannot_delete_any_collection()
    {
        $response = $this->deleteJson(route('collection.destroy', 1));

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_create_any_collection()
    {
        $this->createAuthenticatedUser();

        $response = $this->deleteJson(route('collection.destroy', 1));

        $response->assertStatus(403);
    }

    public function test_an_authenticated_admin_can_delete_a_collection()
    {
        $this->createAuthenticatedAdmin();
        $quality = Collection::factory()->create();

        $response = $this->deleteJson(route('collection.destroy', $quality->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('collections', ['id' => $quality->id]);
    }

    public function test_an_authenticated_seller_can_delete_his_collection()
    {
        $user = $this->createAuthenticatedSeller();
        $quality = Collection::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson(route('collection.destroy', $quality->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('collections', ['id' => $quality->id]);
    }

    public function test_an_authenticated_seller_cannot_delete_a_collection_that_not_him()
    {
        $this->createAuthenticatedSeller();
        $quality = Collection::factory()->create();

        $response = $this->deleteJson(route('collection.destroy', $quality->id));

        $response->assertNotFound();
    }
}
