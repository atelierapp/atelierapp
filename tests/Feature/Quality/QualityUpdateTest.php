<?php

namespace Tests\Feature\Quality;

use App\Models\Quality;
use Tests\TestCase;

class QualityUpdateTest extends TestCase
{
    public function test_a_guess_cannot_update_any_quality()
    {
        $response = $this->patchJson(route('quality.update', 1), []);

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_update_any_quality()
    {
        $this->createAuthenticatedUser();

        $response = $this->patchJson(route('quality.update', 1), []);

        $response->assertStatus(403);
    }

    public function test_an_authenticated_admin_can_update_any_quality()
    {
        $this->createAuthenticatedAdmin();
        $quality = Quality::factory()->create();

        $data = [
            'name' => $this->faker->name,
        ];
        $response = $this->patchJson(route('quality.update', $quality->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
        $this->assertDatabaseHas('qualities', $data);
    }
}
