<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\ManufacturerTypeEnum;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @title Products
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     * @title List products
     */
    public function index_behaves_as_expected(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->get(route('product.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'title',
                    'manufacturer_type',
                    'manufactured_at',
                    'description',
                    'price'
                ]
            ],
            'meta' => [
                'links',
            ]
        ]);
    }

    /**
     * @test
     * @title List products with filters
     */
    public function index_accepts_filters()
    {
        $this->markTestIncomplete('The list should be able to accept filters.');
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
     * @title Create product
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
     * @title Create product
     */
    public function store_a_product_with_tags(): void
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
            'tags' => [
                ['name' => $tag = $this->faker->text(30)],
                ['name' => $this->faker->text(30)],
            ]
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
                    'tags' => [
                        0 => [
                            'id',
                            'name',
                            'active',
                        ]
                     ]
                ],
            ]
        );
        $this->assertDatabaseHas('tags', [
            'taggable_type' => Product::class,
            'name' => $tag
        ]);

        $data = collect($data)->except(['properties', 'manufactured_at', 'tags'])->toArray();
        $this->assertDatabaseHas('products', $data);
    }

    /**
     * @test
     * @title Create product
     */
    public function store_a_product_with_media(): void
    {
        $this->markTestSkipped('Implementar prueba con s3');
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
            'attach' => [
                ['file' => UploadedFile::fake()->image('attachmedia1.jpg')],
                ['file' => UploadedFile::fake()->image('attachmedia2.jpg')],
            ],
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
                    'tags' => [
                        0 => [
                            'id',
                            'name',
                            'active',
                        ]
                    ]
                ],
            ]
        );
//        $this->assertDatabaseHas('tags', [
//            'taggable_type' => Product::class,
//            'name' => $tag
//        ]);

//        $data = collect($data)->except(['properties', 'manufactured_at', 'attach'])->toArray();
//        $this->assertDatabaseHas('products', $data);
    }

    /**
     * @test
     * @title Show product
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
     * @title Update product
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
     * @title Delete product
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('product.destroy', $product));

        $response->assertNoContent();

        $this->assertSoftDeleted($product);
    }
}
