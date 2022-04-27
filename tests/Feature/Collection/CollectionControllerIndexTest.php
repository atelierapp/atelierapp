<?php

namespace Tests\Feature\Collection;

use App\Models\Collection;
use Tests\TestCase;

class CollectionControllerIndexTest extends TestCase
{
    public function test_a_guess_user_cannot_list_any_collection()
    {
        $response = $this->getJson(route('collection.index'));

        $response->assertUnauthorized();
    }

    public function test_a_guess_user_can_list_all_qualities()
    {
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
    }

    protected function setUp(): void
    {
        parent::setUp();
        Collection::factory()->count(10)->create();
    }
}
