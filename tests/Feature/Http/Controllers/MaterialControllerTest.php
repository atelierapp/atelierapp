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

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $materials = Material::factory()->count(3)->create();

        $response = $this->get(route('material.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
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
        $name = $this->faker->name;
        $active = $this->faker->boolean;

        $response = $this->post(
            route('material.store'),
            [
                'name' => $name,
                'active' => $active,
            ]
        );

        $materials = Material::query()
            ->where('name', $name)
            ->where('active', $active)
            ->get();

        $this->assertCount(1, $materials);
        $material = $materials->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }

    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $material = Material::factory()->create();

        $response = $this->get(route('material.show', $material));

        $response->assertOk();
        $response->assertJsonStructure([]);
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
        $name = $this->faker->name;
        $active = $this->faker->boolean;

        $response = $this->put(
            route('material.update', $material),
            [
                'name' => $name,
                'active' => $active,
            ]
        );

        $material->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $material->name);
        $this->assertEquals($active, $material->active);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $material = Material::factory()->create();

        $response = $this->delete(route('material.destroy', $material));

        $response->assertNoContent();

        $this->assertSoftDeleted($material);
    }
}
