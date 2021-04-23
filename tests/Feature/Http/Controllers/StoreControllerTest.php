<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\20;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\StoreController
 */
class StoreControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $stores = Store::factory()->count(3)->create();

        $response = $this->get(route('store.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StoreController::class,
            'store',
            \App\Http\Requests\StoreStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $name = $this->faker->name;
        $legal_name = $this->faker->word;
        $legal = 20::factory()->create();
        $story = $this->faker->word;
        $logo = $this->faker->word;
        $active = $this->faker->boolean;

        $response = $this->post(route('store.store'), [
            'name' => $name,
            'legal_name' => $legal_name,
            'legal_id' => $legal->id,
            'story' => $story,
            'logo' => $logo,
            'active' => $active,
        ]);

        $stores = Store::query()
            ->where('name', $name)
            ->where('legal_name', $legal_name)
            ->where('legal_id', $legal->id)
            ->where('story', $story)
            ->where('logo', $logo)
            ->where('active', $active)
            ->get();
        $this->assertCount(1, $stores);
        $store = $stores->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $store = Store::factory()->create();

        $response = $this->get(route('store.show', $store));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StoreController::class,
            'update',
            \App\Http\Requests\StoreUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $store = Store::factory()->create();
        $name = $this->faker->name;
        $legal_name = $this->faker->word;
        $legal = 20::factory()->create();
        $story = $this->faker->word;
        $logo = $this->faker->word;
        $active = $this->faker->boolean;

        $response = $this->put(route('store.update', $store), [
            'name' => $name,
            'legal_name' => $legal_name,
            'legal_id' => $legal->id,
            'story' => $story,
            'logo' => $logo,
            'active' => $active,
        ]);

        $store->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $store->name);
        $this->assertEquals($legal_name, $store->legal_name);
        $this->assertEquals($legal->id, $store->legal_id);
        $this->assertEquals($story, $store->story);
        $this->assertEquals($logo, $store->logo);
        $this->assertEquals($active, $store->active);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $store = Store::factory()->create();

        $response = $this->delete(route('store.destroy', $store));

        $response->assertNoContent();

        $this->assertSoftDeleted($store);
    }
}
