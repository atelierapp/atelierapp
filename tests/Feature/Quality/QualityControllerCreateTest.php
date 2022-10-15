<?php

namespace Tests\Feature\Quality;

use Tests\TestCase;

class QualityControllerCreateTest extends TestCase
{
    public function test_a_guess_cannot_create_any_quality()
    {
        $response = $this->postJson(route('quality.store'), [], $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_create_any_quality()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('quality.store'), [], $this->customHeaders());

        $response->assertStatus(403);
    }

    public function test_an_authenticated_admin_can_create_a_quality()
    {
        $this->createAuthenticatedAdmin();

        $data = [
            'name' => $this->faker->name,
            'score' => $this->faker->numberBetween(1, 5),
        ];
        $response = $this->postJson(route('quality.store'), $data, $this->customHeaders());

        $response->assertCreated();
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
        ]);
    }
}
