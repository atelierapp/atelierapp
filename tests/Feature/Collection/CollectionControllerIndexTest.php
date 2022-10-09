<?php

namespace Tests\Feature\Collection;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class CollectionControllerIndexTest extends TestCase
{
    public function test_a_guess_user_cannot_list_any_collection()
    {
        $response = $this->getJson(route('collection.index'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_user_can_list_all_active_collections_by_default()
    {
        $user = $this->createAuthenticatedUser();
        Collection::factory()->count(10)->pe()->state(new Sequence(
            ['is_active' => true], ['is_active' => false]
        ))->create(['user_id' => $user->id]);

        $response = $this->getJson(route('collection.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                    'is_active',
                ],
            ],
        ]);
        $response->assertJsonCount(5, 'data');
    }

    public function test_a_authenticated_user_can_list_all_active_collection()
    {
        $user = $this->createAuthenticatedUser();
        Collection::factory()->count(10)->pe()->create(['user_id' => $user->id]);

        $response = $this->getJson(route('collection.index', ['with_all' => true]), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                    'is_active',
                ],
            ],
        ]);
        $response->assertJsonCount(10, 'data');
    }
}
