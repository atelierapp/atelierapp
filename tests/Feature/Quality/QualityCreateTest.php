<?php

namespace Tests\Feature\Quality;

use Tests\TestCase;

class QualityCreateTest extends TestCase
{
    public function test_a_guess_cannot_create_any_quality()
    {
        $response = $this->postJson(route('quality.store'), []);

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_create_any_quality()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('quality.store'), []);

        $response->assertStatus(403);
    }

    public function test_an_authenticated_admin_can_create_a_quality()
    {
        $this->createAuthenticatedAdmin();

        $data = [
            'name' => $this->faker->name,
        ];
        $response = $this->postJson(route('quality.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);
        $this->assertDatabaseHas('qualities', $data);
    }
}
