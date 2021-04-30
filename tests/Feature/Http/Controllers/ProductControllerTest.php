<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\ManufacturerTypeEnum;
use App\Models\Product;
use App\Models\Style;
use App\Models\Tag;
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
        $params = [
            'search' => 'test-product'
        ];
        Product::factory()->count(4)->create();
        Product::factory()->create(['title' => $params['search']]);

        $response = $this->get(route('product.index', $params));

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'title',
                    'manufacturer_type_code',
                    'manufacturer_type',
                    'manufactured_at',
                    'description',
                    'price',
                    'style_id',
                    'style',
                    'quantity',
                    'sku',
                    'active',
                ]
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
        $this->assertDatabaseCount('products', 5);
    }

    /**
     * @test
     * @title List products with filters
     */
    public function index_accepts_filters()
    {
        Product::factory()->times(5)->hasTags(2)->hasCategories(2)->hasMedias(2)->create();

        $response = $this->get(route('product.index'));

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'title',
                    'manufacturer_type_code',
                    'manufacturer_type',
                    'manufactured_at',
                    'description',
                    'price',
                    'style_id',
                    'style',
                    'quantity',
                    'sku',
                    'active',
                ]
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
        $this->assertDatabaseCount('products', 5);
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
            'style_id' => Style::factory()->create()->id
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
                    'style_id',
                    'style',
                    'quantity',
                    'sku',
                    'active',
                    'properties',
                ],
            ]
        );
        $this->assertDatabaseHas(
            'products',
            collect($data)->except(['properties', 'manufactured_at'])->toArray()
        );
    }

    /**
     * @test
     * @title Create product
     */
    public function store_a_product_with_tags(): void
    {
        $tag = Tag::factory()->create();
        $tag2 = Tag::factory()->create();
        $data = [
            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufactured_at' => $this->faker->date('m/d/Y'),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'sku' => $this->faker->word,
            'active' => true,
            'style_id' => Style::factory()->create()->id,
            'properties' => ['demo' => $this->faker->word],
            'tags' => [
                ['name' => $tag->name],
                ['name' => $tag2->name],
            ]
        ];

        $response = $this->postJson(route('product.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'title',
                    'manufacturer_type_code',
                    'manufacturer_type',
                    'manufactured_at',
                    'description',
                    'price',
                    'style_id',
                    'style',
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
        $this->assertDatabaseHas(
            'taggables',
            [
                'taggable_type' => Product::class,
                'tag_id' => $tag->id
            ]
        );
        $this->assertDatabaseHas(
            'taggables',
            [
                'taggable_type' => Product::class,
                'tag_id' => $tag2->id
            ]
        );

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
        $product = Product::factory()->hasTags(2)->hasCategories(2)->hasMedias(2)->create();

        $response = $this->get(route('product.show', $product));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'manufacturer_type_code',
                'manufacturer_type',
                'manufactured_at',
                'description',
                'price',
                'style_id',
                'style',
                'quantity',
                'sku',
                'active',
                'properties',
                'medias' => [
                    '*' => [
                        'id',
                        'type_id',
                        'url',
                    ]
                ],
                'tags' => [
                    '*' => [
                        'id',
                        'name',
                        'active',
                    ]
                ],
                'categories' => [
                    '*' => [
                        'id',
                        'name',
                        'image',
                        'parent_id',
                        'active',
                    ]
                ],
            ]
        ]);
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
                    'manufacturer_type_code',
                    'manufacturer_type',
                    'manufactured_at',
                    'description',
                    'price',
                    'style_id',
                    'style',
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
