<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\UnitSystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @title Unit Systems
 * @see \App\Http\Controllers\UnitSystemController
 */
class UnitSystemControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    private function structure(): array
    {
        return [
            'id',
            'name',
        ];
    }

    /**
     * @test
     * @title List unit systems
     */
    public function index_behaves_as_expected(): void
    {
        UnitSystem::factory()->count(3)->create();

        $response = $this->get(route('unit-system.index'), $this->customHeaders());

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
            \App\Http\Controllers\UnitSystemController::class,
            'store',
            \App\Http\Requests\UnitSystemStoreRequest::class
        );
    }

    /**
     * @test
     * @title Create unit system
     */
    public function store_saves(): void
    {
        $name = $this->faker->text(15);

        $response = $this->postJson(
            route('unit-system.store'),
            [
                'name' => $name,
            ], $this->customHeaders()
        );

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);

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
     * @title Show unit system
     */
    public function show_behaves_as_expected(): void
    {
        $unitSystem = UnitSystem::factory()->create();

        $response = $this->get(route('unit-system.show', $unitSystem), $this->customHeaders());

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
     * @title Update unit system
     */
    public function update_behaves_as_expected(): void
    {
        $unitSystem = UnitSystem::factory()->create();
        $name = $this->faker->text(15);

        $response = $this->put(route('unit-system.update', $unitSystem), [
            'name' => $name,
        ], $this->customHeaders());

        $unitSystem->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);

        $this->assertEquals($name, $unitSystem->name);
    }


    /**
     * @test
     * @title Delete unit system
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $unitSystem = UnitSystem::factory()->create();

        $response = $this->delete(route('unit-system.destroy', $unitSystem), [], $this->customHeaders());

        $response->assertNoContent();

        $this->assertSoftDeleted($unitSystem);
    }
}
