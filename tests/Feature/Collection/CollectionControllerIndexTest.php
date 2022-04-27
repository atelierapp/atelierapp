<?php

namespace Tests\Feature\Collection;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class CollectionControllerIndexTest extends TestCase
{
    public function test_a_guess_user_cannot_list_any_collection()
    {
        $response = $this->getJson(route('collection.index'));

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_user_can_list_all_active_collections_by_default()
    {
        Collection::factory()->count(10)->state(new Sequence(
            ['is_active' => true], ['is_active' => false]
        ))->create();
        $this->createAuthenticatedUser();

        $response = $this->getJson(route('collection.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                ],
            ],
        ]);
        $response->assertJsonCount(5, 'data');
    }

    public function test_a_authenticated_user_can_list_all_active_collection()
    {
        Collection::factory()->count(10)->create();
        $this->createAuthenticatedUser();

        $response = $this->getJson(route('collection.index', ['with_all' => true]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                ],
            ],
        ]);
        $response->assertJsonCount(10, 'data');
    }
}
