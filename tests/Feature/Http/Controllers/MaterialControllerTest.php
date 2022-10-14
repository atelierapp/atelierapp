<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MaterialController
 */
class MaterialControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    private function structure(): array
    {
        return [
            'id',
            'name',
            'image',
            'active',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        Material::factory()->count(3)->create();

        $response = $this->get(route('material.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => $this->structure()
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ]
        ]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MaterialController::class,
            'store',
            \App\Http\Requests\MaterialStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $name = $this->faker->text(20);
        $active = $this->faker->boolean;

        $response = $this->post(
            route('material.store'),
            [
                'name' => $name,
                'active' => $active,
            ], $this->customHeaders()
        );

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);

        $this->assertDatabaseCount('materials', 1);
    }

    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $material = Material::factory()->create();

        $response = $this->get(route('material.show', $material), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MaterialController::class,
            'update',
            \App\Http\Requests\MaterialUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $material = Material::factory()->create();
        $name = $this->faker->text(20);
        $active = $this->faker->boolean;

        $response = $this->putJson(
            route('material.update', $material),
            [
                'name' => $name,
                'active' => $active,
            ], $this->customHeaders()
        );

        $material->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);

        $this->assertEquals($name, $material->name);
        $this->assertEquals($active, $material->active);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $material = Material::factory()->create();

        $response = $this->delete(route('material.destroy', $material), [], $this->customHeaders());

        $response->assertNoContent();

        $this->assertSoftDeleted($material);
    }
}
