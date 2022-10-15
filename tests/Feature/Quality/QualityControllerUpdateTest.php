<?php

namespace Tests\Feature\Quality;

use App\Models\Quality;
use Tests\TestCase;

class QualityControllerUpdateTest extends TestCase
{
    public function test_a_guess_cannot_update_any_quality()
    {
        $response = $this->patchJson(route('quality.update', 1), [], $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_update_any_quality()
    {
        $this->createAuthenticatedUser();

        $response = $this->patchJson(route('quality.update', 1), [], $this->customHeaders());

        $response->assertStatus(403);
    }

    public function test_an_authenticated_admin_can_update_any_quality()
    {
        $this->createAuthenticatedAdmin();
        $quality = Quality::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'score' => $this->faker->numberBetween(1, 5),
        ];
        $response = $this->patchJson(route('quality.update', $quality->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'score',
            ],
        ]);
        $this->assertDatabaseHas('qualities', [
            'id' => $response->json('data.id'),
            'name->es' => $data['name'],
            'score' => $data['score'],
        ]);
    }
}
