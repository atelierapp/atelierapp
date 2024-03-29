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
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    private function structure(): array
    {
        return [
            'id',
            'name',
            'image',
        ];
    }

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        MediaType::factory()->count(3)->create();

        $response = $this->get(route('media-type.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [

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
                'next',
            ],
        ]);
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
        $name = $this->faker->text(20);

        $response = $this->post(route('media-type.store'), [
            'name' => $name,
        ], $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas('media_types', [
            'name' => $name,
        ]);
    }

    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $mediaType = MediaType::factory()->create();

        $response = $this->get(route('media-type.show', $mediaType), $this->customHeaders());

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
        $name = $this->faker->text(20);

        $response = $this->putJson(route('media-type.update', $mediaType), [
            'name' => $name,
        ], $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $name);
    }

    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $mediaType = MediaType::factory()->create();

        $response = $this->delete(route('media-type.destroy', $mediaType), [], $this->customHeaders());

        $response->assertNoContent();

        $this->assertSoftDeleted($mediaType);
    }
}
