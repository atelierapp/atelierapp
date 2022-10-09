<?php

namespace Tests\Feature\Collection;

use App\Models\Collection;
use Tests\TestCase;

class CollectionFeaturedControllerIndexTest extends TestCase
{
    public function test_a_guess_user_cannot_list_any_collection()
    {
        $response = $this->getJson(route('collection.featured'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_user_can_list_all_active_collections_by_default()
    {
        $this->createAuthenticatedUser();
        Collection::factory()->count(10)->pe()->create(['is_featured' => true]);
        Collection::factory()->count(10)->pe()->create(['is_featured' => false]);

        $response = $this->getJson(route('collection.featured'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(10, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                    'is_active',
                    'is_featured',
                ],
            ],
        ]);
    }
}
