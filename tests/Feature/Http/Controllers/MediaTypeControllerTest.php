<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\MediaType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MediaTypeController
 */
class MediaTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $mediaTypes = MediaType::factory()->count(3)->create();

        $response = $this->get(route('media-type.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MediaTypeController::class,
            'store',
            \App\Http\Requests\MediaTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $name = $this->faker->name;

        $response = $this->post(route('media-type.store'), [
            'name' => $name,
        ]);

        $mediaTypes = MediaType::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $mediaTypes);
        $mediaType = $mediaTypes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $mediaType = MediaType::factory()->create();

        $response = $this->get(route('media-type.show', $mediaType));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MediaTypeController::class,
            'update',
            \App\Http\Requests\MediaTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $mediaType = MediaType::factory()->create();
        $name = $this->faker->name;

        $response = $this->put(route('media-type.update', $mediaType), [
            'name' => $name,
        ]);

        $mediaType->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $mediaType->name);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $mediaType = MediaType::factory()->create();

        $response = $this->delete(route('media-type.destroy', $mediaType));

        $response->assertNoContent();

        $this->assertSoftDeleted($mediaType);
    }
}
