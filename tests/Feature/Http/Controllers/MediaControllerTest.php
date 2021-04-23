<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Media;
use App\Models\MediaType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MediaController
 */
class MediaControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        Media::factory()->count(3)->create();

        $response = $this->get(route('medium.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MediaController::class,
            'store',
            \App\Http\Requests\MediaStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $type = MediaType::factory()->create();
        $url = $this->faker->url;
        $main = $this->faker->boolean;

        $response = $this->post(route('medium.store'), [
            'type_id' => $type->id,
            'url' => $url,
            'main' => $main,
        ]);

        $media = Medium::query()
            ->where('type_id', $type->id)
            ->where('url', $url)
            ->where('main', $main)
            ->get();
        $this->assertCount(1, $media);
        $medium = $media->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $medium = Media::factory()->create();

        $response = $this->get(route('medium.show', $medium));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MediaController::class,
            'update',
            \App\Http\Requests\MediaUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $medium = Media::factory()->create();
        $type = MediaType::factory()->create();
        $url = $this->faker->url;
        $main = $this->faker->boolean;

        $response = $this->put(route('medium.update', $medium), [
            'type_id' => $type->id,
            'url' => $url,
            'main' => $main,
        ]);

        $medium->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($type->id, $medium->type_id);
        $this->assertEquals($url, $medium->url);
        $this->assertEquals($main, $medium->main);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $medium = Media::factory()->create();
        $medium = Medium::factory()->create();

        $response = $this->delete(route('medium.destroy', $medium));

        $response->assertNoContent();

        $this->assertDeleted($medium);
    }
}
