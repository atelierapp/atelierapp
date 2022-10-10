<?php

namespace Tests\Feature\Quality;

use App\Models\Quality;
use Tests\TestCase;

class QualityControllerDeleteTest extends TestCase
{
    public function test_a_guess_cannot_delete_any_quality()
    {
        $response = $this->deleteJson(route('quality.destroy', 1), [], $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_create_any_quality()
    {
        $this->createAuthenticatedUser();

        $response = $this->deleteJson(route('quality.destroy', 1), [], $this->customHeaders());

        $response->assertStatus(403);
    }

    public function test_an_authenticated_admin_can_delete_a_quality()
    {
        $this->createAuthenticatedAdmin();
        $quality = Quality::factory()->create();

        $response = $this->deleteJson(route('quality.destroy', $quality->id), [], $this->customHeaders());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('qualities', ['id' => $quality->id]);
    }
}
