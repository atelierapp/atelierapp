<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @title Tags
 * @see \App\Http\Controllers\TagController
 */
class TagControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     * List tags
     */
    public function index_behaves_as_expected(): void
    {
        $tags = Tag::factory()->count(3)->create();

        $response = $this->get(route('tag.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->markTestIncomplete('The list should be paginated.');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TagController::class,
            'store',
            \App\Http\Requests\TagStoreRequest::class
        );
    }

    /**
     * @test
     * Create tag
     */
    public function store_saves(): void
    {
        $name = $this->faker->name;
        $active = $this->faker->boolean;

        $response = $this->post(route('tag.store'), [
            'name' => $name,
            'active' => $active,
        ]);

        $tags = Tag::query()
            ->where('name', $name)
            ->where('active', $active)
            ->get();
        $this->assertCount(1, $tags);
        $tag = $tags->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     * Show tag
     */
    public function show_behaves_as_expected(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->get(route('tag.show', $tag));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TagController::class,
            'update',
            \App\Http\Requests\TagUpdateRequest::class
        );
    }

    /**
     * @test
     * Update tag
     */
    public function update_behaves_as_expected(): void
    {
        $tag = Tag::factory()->create();
        $name = $this->faker->name;
        $active = $this->faker->boolean;

        $response = $this->put(route('tag.update', $tag), [
            'name' => $name,
            'active' => $active,
        ]);

        $tag->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $tag->name);
        $this->assertEquals($active, $tag->active);
    }


    /**
     * @test
     * Delete tag
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->delete(route('tag.destroy', $tag));

        $response->assertNoContent();

        $this->assertSoftDeleted($tag);
    }
}
