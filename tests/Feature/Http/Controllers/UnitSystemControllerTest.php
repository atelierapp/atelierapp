<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\UnitSystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UnitSystemController
 */
class UnitSystemControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        UnitSystem::factory()->count(3)->create();

        $response = $this->get(route('unit-system.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitSystemController::class,
            'store',
            \App\Http\Requests\UnitSystemStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $name = $this->faker->text(15);

        $response = $this->postJson(
            route('unit-system.store'),
            [
                'name' => $name,
            ]
        );

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this
            ->assertDatabaseCount('unit_systems', 1)
            ->assertDatabaseHas(
                'unit_systems',
                [
                    'name' => $name,
                ]
            );
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $unitSystem = UnitSystem::factory()->create();

        $response = $this->get(route('unit-system.show', $unitSystem));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitSystemController::class,
            'update',
            \App\Http\Requests\UnitSystemUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $unitSystem = UnitSystem::factory()->create();
        $name = $this->faker->text(15);

        $response = $this->put(route('unit-system.update', $unitSystem), [
            'name' => $name,
        ]);

        $unitSystem->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $unitSystem->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $unitSystem = UnitSystem::factory()->create();

        $response = $this->delete(route('unit-system.destroy', $unitSystem));

        $response->assertNoContent();

        $this->assertSoftDeleted($unitSystem);
    }
}
