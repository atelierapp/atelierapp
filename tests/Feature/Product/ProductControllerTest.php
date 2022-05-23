<?php

namespace Product;

use App\Enums\ManufacturerTypeEnum;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Style;
use App\Models\Tag;
use Database\Seeders\MediaTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

use function collect;
use function route;

/**
 * @title Products
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use AdditionalAssertions;

    /**
     * @title Show product
     */
    public function show_behaves_as_expected(): void
    {
        $this->markTestSkipped();
        Storage::fake('s3');
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
                'url',
                'medias' => [
                    '*' => [
                        'id',
                        'type_id',
                        'url',
                        'orientation',
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
