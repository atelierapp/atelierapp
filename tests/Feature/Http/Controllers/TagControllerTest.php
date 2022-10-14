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

    private function structure()
    {
        return [
            'id',
            'name',
            'active',
        ];
    }

    /**
     * @test
     * List tags
     */
    public function index_behaves_as_expected(): void
    {
        Tag::factory()->count(3)->create();

        $response = $this->get(route('tag.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(
            [
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
            ]
        );
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
     * Show tag
     */
    public function show_behaves_as_expected(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->get(route('tag.show', $tag), $this->customHeaders());

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

        $response = $this->put(
            route('tag.update', $tag),
            [
                'name' => $name,
                'active' => $active,
            ], $this->customHeaders()
        );

        $tag->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);

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

        $response = $this->delete(route('tag.destroy', $tag), [], $this->customHeaders());

        $response->assertNoContent();

        $this->assertSoftDeleted($tag);
    }
}
