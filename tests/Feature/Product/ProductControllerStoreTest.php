<?php

namespace Tests\Feature\Product;

use App\Enums\ManufacturerProcessEnum;
use App\Enums\ManufacturerTypeEnum;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Media;
use App\Models\Product;
use App\Models\Quality;
use App\Models\Store;
use App\Models\Variation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;

/**
 * @title Products
 * @group products
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerStoreTest extends BaseTest
{
    use AdditionalAssertions;

    public function test_a_guess_cannot_create_any_product()
    {
        $response = $this->postJson(route('product.store'), []);

        $response->assertUnauthorized();
    }

    public function test_store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'store',
            \App\Http\Requests\ProductStoreRequest::class
        );
    }

    public function test_authenticated_seller_cannot_store_a_product_without_any_required_param()
    {
        $this->createAuthenticatedSeller();

        $response = $this->postJson(route('product.store'), [], $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'store_id',
            'title',
            'manufacturer_process',
            'category_id',
            'description',
            'images',
            'depth',
            'height',
            'width',
            'tags',
            'materials',
            'price',
            'quantity',
        ]);
    }

    public function test_authenticated_seller_cannot_store_a_product_with_invalid_params()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'title' => $this->faker->name,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),

            'store_id' => 'invalid_param',
            'category_id' => 'invalid_param',
            'manufacturer_type' => 'invalid_param',
            'manufacturer_process' => 'invalid_param',
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'store_id',
            'category_id',
            'manufacturer_process',
        ]);
    }

    public function test_authenticated_seller_cannot_store_a_product_with_all_orientation_required_images()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
            ],
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'images',
        ]);
    }

    public function test_authenticated_seller_cannot_store_a_product_with_invalid_images_or_orientation()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')], // 1
                ['orientation' => 'plan', 'file' => 'invalid_image'], // 2
                ['orientation' => 'invalid_orientation', 'file' => UploadedFile::fake()->image('plan.png')], // 3
            ],
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'images.3.orientation',
            'images.2.file',
        ]);
    }

    public function test_authenticated_seller_cannot_store_a_product_store_id_that_not_him()
    {
        Storage::fake('s3');
        $this->createStore($this->createAuthenticatedSeller());

        $data = [
            'store_id' => Store::factory()->create()->id,
            'title' => $this->faker->name,
            'manufacturer_type' => $this->faker->randomElement(array_keys(ManufacturerTypeEnum::MAP_VALUE)),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(
            [
                'store_id',
            ]
        );
        $this->assertDatabaseCount('products', 0);
    }

    public function test_authenticated_seller_can_store_a_product_with_only_required_info_and_images()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => $this->structure(),
            ]
        );
        $response->assertJsonStructure(
            [
                'data' => ['qualities'],
            ]
        );
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('media', 8);
        $this->assertEquals(2, Media::featured()->count());
        $this->assertEquals(6, Media::nonFeatured()->count());
        $this->assertDatabaseCount('tags', 3);
        $this->assertDatabaseCount('taggables', 3);
        $this->assertDatabaseCount('materials', 5);
        $this->assertDatabaseCount('material_product', 5);
        $this->assertDatabaseCount('qualityables', 2);
        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
            'country' => config('app.country'),
        ]);
    }

    public function test_authenticated_seller_can_store_a_product_with_only_required_info_and_images_and_duplicated_as_variation()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $response->assertJsonStructure(
            [
                'data' => [
                    'medias' => [
                        0 => [
                            'type_id',
                            'url',
                            'orientation'
                        ]
                    ],
                    'tags' => [
                        0 => [
                            'id',
                            'name',
                        ],
                    ],
                    'materials' => [
                        0 => [
                            'id',
                            'name',
                        ]
                    ],
                    'categories' => [
                        0 => [
                            'id',
                            'name',
                        ]
                    ],
                    'variations' => [
                        0 => [
                            'name',
                            'medias' => [
                                0 => [
                                    'type_id',
                                    'url',
                                    'orientation'
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
            'country' => config('app.country'),
        ]);
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('media', 8);
        $this->assertEquals(1, Media::featured()->model(Product::class)->count());
        $this->assertEquals(3, Media::nonFeatured()->model(Product::class)->count());
        $this->assertDatabaseCount('tags', 3);
        $this->assertDatabaseCount('taggables', 3);
        $this->assertDatabaseCount('materials', 5);
        $this->assertDatabaseCount('material_product', 5);
        $this->assertDatabaseCount('variations', 1);
        $this->assertDatabaseCount('qualityables', 2);
        $this->assertEquals(1, Media::featured()->model(Variation::class)->count());
        $this->assertEquals(3, Media::nonFeatured()->model(Variation::class)->count());
    }

    public function test_authenticated_seller_can_store_a_product_with_only_required_info_and_images_and_collections()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());
        Collection::factory()->count(3)->create();

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],

            'collections' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $response->assertJsonStructure(
            [
                'data' => [
                    'collections' => [
                        0 => [
                            'id',
                            'name'
                        ]
                    ]
                ],
            ]
        );
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
            'country' => config('app.country'),
        ]);
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('media', 8);
        $this->assertEquals(2, Media::featured()->count());
        $this->assertEquals(6, Media::nonFeatured()->count());
        $this->assertEquals(3, Collection::authUser()->count());
        $this->assertDatabaseCount('collectionables', 3);
        $this->assertDatabaseCount('qualityables', 2);
    }

    public function test_authenticated_seller_can_store_a_product_with_info_and_images_and_one_variations()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
            'materials' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
            'variations' => [
                [
                    'name' => $this->faker->title,
                    'images' => [
                        ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                        ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                        ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                        ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
                    ],
                ]
            ]
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $response->assertJsonStructure(
            [
                'data' => [
                    'medias' => [
                        0 => [
                            'type_id',
                            'url',
                            'orientation'
                        ]
                    ],
                    'tags' => [
                        0 => [
                            'id',
                            'name',
                        ],
                    ],
                    'materials' => [
                        0 => [
                            'id',
                            'name',
                        ]
                    ],
                    'categories' => [
                        0 => [
                            'id',
                            'name',
                        ]
                    ],
                    'variations' => [
                        0 => [
                            'name',
                            'medias' => [
                                0 => [
                                    'type_id',
                                    'url',
                                    'orientation'
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
            'country' => config('app.country'),
        ]);
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('tags', 3);
        $this->assertDatabaseCount('taggables', 3);
        $this->assertDatabaseCount('materials', 5);
        $this->assertDatabaseCount('material_product', 5);
        $this->assertDatabaseCount('variations', 2);
        $this->assertDatabaseCount('media', 12);
        $this->assertDatabaseCount('qualityables', 2);
        $this->assertEquals(1, Media::featured()->model(Product::class)->count());
        $this->assertEquals(3, Media::nonFeatured()->model(Product::class)->count());
        $this->assertEquals(2, Media::featured()->model(Variation::class)->count());
        $this->assertEquals(6, Media::nonFeatured()->model(Variation::class)->count());
    }

    public function test_authenticated_seller_can_store_a_product_with_info_and_images_and_two_variations()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
            ],
            'materials' => [
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
                ['name' => $this->faker->unique()->word],
            ],
            'variations' => [
                [
                    'name' => $this->faker->title,
                    'images' => [
                        ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                        ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                        ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                        ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
                    ],
                ],
                [
                    'name' => $this->faker->title,
                    'images' => [
                        ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                        ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                        ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                        ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
                    ],
                ],
            ]
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $response->assertJsonStructure(
            [
                'data' => [
                    'medias' => [
                        0 => [
                            'type_id',
                            'url',
                            'orientation'
                        ]
                    ],
                    'tags' => [
                        0 => [
                            'id',
                            'name',
                        ],
                    ],
                    'materials' => [
                        0 => [
                            'id',
                            'name',
                        ]
                    ],
                    'categories' => [
                        0 => [
                            'id',
                            'name',
                        ]
                    ],
                    'variations' => [
                        0 => [
                            'name',
                            'medias' => [
                                0 => [
                                    'type_id',
                                    'url',
                                    'orientation'
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
            'country' => config('app.country'),
        ]);
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('tags', 3);
        $this->assertDatabaseCount('taggables', 3);
        $this->assertDatabaseCount('materials', 5);
        $this->assertDatabaseCount('material_product', 5);
        $this->assertDatabaseCount('variations', 3);
        $this->assertDatabaseCount('media', 16);
        $this->assertDatabaseCount('qualityables', 2);
        $this->assertEquals(1, Media::featured()->model(Product::class)->count());
        $this->assertEquals(3, Media::nonFeatured()->model(Product::class)->count());
        $this->assertEquals(3, Media::featured()->model(Variation::class)->count());
        $this->assertEquals(9, Media::nonFeatured()->model(Variation::class)->count());
    }

    public function test_authenticated_seller_can_store_a_product_with_required_info_more_images_more_is_on_demand_more_is_unique_param()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->name],
            ],
            'is_on_demand' => $this->faker->boolean,
            'is_unique' => $this->faker->boolean,
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => $this->structure(),
            ]
        );
        $this->assertEquals($data['is_on_demand'], $response->json('data.is_on_demand'));
        $this->assertEquals($data['is_unique'], $response->json('data.is_unique'));
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
            'country' => config('app.country'),
        ]);
        $this->assertDatabaseCount('category_product', 1);
        $this->assertDatabaseCount('media', 8);
        $this->assertEquals(2, Media::featured()->count());
        $this->assertEquals(6, Media::nonFeatured()->count());
        $this->assertDatabaseCount('tags', 1);
        $this->assertDatabaseCount('taggables', 1);
        $this->assertDatabaseCount('materials', 1);
        $this->assertDatabaseCount('material_product', 1);
        $this->assertDatabaseCount('qualityables', 2);
    }

    public function test_authenticated_seller_can_not_store_a_product_with_discount_without_required_fields()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => $this->faker->numberBetween(10000, 100000) / 100,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
            'has_discount' => true,
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['is_discount_fixed', 'discount_value']);
    }

    public function test_authenticated_seller_can_create_a_product_with_percent_discount()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => 150,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
            'has_discount' => true,
            'is_discount_fixed' => false,
            'discount_value' => 25,
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
            'country' => config('app.country'),
            'has_discount' => $data['has_discount'],
            'is_discount_fixed' => $data['is_discount_fixed'],
            'discount_value' => $data['discount_value'],
        ]);
        $this->assertEquals($data['has_discount'], $response->json('data.has_discount'));
        $this->assertEquals($data['is_discount_fixed'], $response->json('data.is_discount_fixed'));
        $this->assertEquals($data['discount_value'], $response->json('data.discount_value'));
        $this->assertEquals(112.5, $response->json('data.final_price'));
    }

    public function test_authenticated_seller_can_create_a_product_with_fixed_discount()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());

        $data = [
            'store_id' => $store->id,
            'title' => $this->faker->name,
            'qualities' => Quality::factory()->count(2)->create()->pluck('id')->toArray(),
            'manufacturer_process' => $this->faker->randomElement(array_keys(ManufacturerProcessEnum::MAP_VALUE)),
            'category_id' => Category::factory()->create()->id,
            'description' => $this->faker->paragraph(),
            'depth' => $this->faker->numberBetween(100, 200),
            'height' => $this->faker->numberBetween(100, 200),
            'width' => $this->faker->numberBetween(100, 200),
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
            'price' => 150,
            'quantity' => $this->faker->numberBetween(1, 10),
            'tags' => [
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
                ['name' => $this->faker->word],
            ],
            'materials' => [
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
                ['name' => $this->faker->name],
            ],
            'has_discount' => true,
            'is_discount_fixed' => true,
            'discount_value' => 25,
        ];
        $response = $this->postJson(route('product.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
            'country' => config('app.country'),
            'has_discount' => $data['has_discount'],
            'is_discount_fixed' => $data['is_discount_fixed'],
            'discount_value' => $data['discount_value'],
        ]);
        $this->assertEquals($data['has_discount'], $response->json('data.has_discount'));
        $this->assertEquals($data['is_discount_fixed'], $response->json('data.is_discount_fixed'));
        $this->assertEquals($data['discount_value'], $response->json('data.discount_value'));
        $this->assertEquals(125, $response->json('data.final_price'));
    }
}
