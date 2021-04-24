<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Unit;
use App\Models\UnitSystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UnitController
 */
class UnitControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $units = Unit::factory()->count(3)->create();

        $response = $this->get(route('unit.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitController::class,
            'store',
            \App\Http\Requests\UnitStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $name = $this->faker->text(20);
        $class = $this->faker->word;
        $factor = $this->faker->randomFloat(2, 10, 20);
        $unit_system = UnitSystem::factory()->create();

        $response = $this->postJson(route('unit.store'), [
            'name' => $name,
            'class' => $class,
            'factor' => $factor,
            'unit_system_id' => $unit_system->id,
        ]);

        $units = Unit::query()
            ->where('name', $name)
            ->where('class', $class)
            ->where('factor', $factor)
            ->where('unit_system_id', $unit_system->id)
            ->get();
        $this->assertCount(1, $units);
        $unit = $units->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $unit = Unit::factory()->create();

        $response = $this->get(route('unit.show', $unit));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitController::class,
            'update',
            \App\Http\Requests\UnitUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $unit = Unit::factory()->create();
        $data = [
            'name' => $this->faker->text(20),
            'class' => $this->faker->word,
            'factor' => $this->faker->randomFloat(2, 10, 20),
            'unit_system_id' => UnitSystem::factory()->create()->id,
        ];

        $response = $this->putJson(route('unit.update', $unit), $data);

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas('units', $data);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $unit = Unit::factory()->create();

        $response = $this->delete(route('unit.destroy', $unit));

        $response->assertNoContent();

        $this->assertSoftDeleted($unit);
    }
}
