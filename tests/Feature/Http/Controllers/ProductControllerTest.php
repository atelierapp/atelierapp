<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\ManufacturerTypeEnum;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->get(route('product.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'store',
            \App\Http\Requests\ProductStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $data = [
            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufactured_at' => $this->faker->date('m/d/Y'),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'sku' => $this->faker->word,
            'active' => true,
            'properties' => ['demo' => $this->faker->word],
        ];

        $response = $this->postJson(route('product.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'title',
                    'manufacturer_type',
                    'manufactured_at',
                    'description',
                    'price',
                    'quantity',
                    'sku',
                    'active',
                    'properties',
                ],
            ]
        );

        $this->assertDatabaseHas('products', collect($data)->except(['properties', 'manufactured_at'])->toArray());
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.show', $product));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'update',
            \App\Http\Requests\ProductUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $product = Product::factory()->create();
        $data = [
            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufactured_at' => $this->faker->date('m/d/Y'),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'sku' => $this->faker->word,
            'active' => true,
            'properties' => ['demo' => $this->faker->word],
        ];

        $response = $this->putJson(route('product.update', $product), $data);

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'title',
                    'manufacturer_type',
                    'manufactured_at',
                    'description',
                    'price',
                    'quantity',
                    'sku',
                    'active',
                    'properties',
                ],
            ]
        );

        $this->assertDatabaseHas('products', collect($data)->except(['properties', 'manufactured_at'])->toArray());
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('product.destroy', $product));

        $response->assertNoContent();

        $this->assertSoftDeleted($product);
    }
}
