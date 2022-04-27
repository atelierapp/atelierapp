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

    public function test_an_authenticated_admin_can_delete_a_quality()
    {
        $this->createAuthenticatedAdmin();
        $quality = Collection::factory()->create();

        $response = $this->deleteJson(route('collection.destroy', $quality->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('collections', ['id' => $quality->id]);
    }
}
