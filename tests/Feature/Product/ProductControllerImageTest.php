<?php

namespace Tests\Feature\Product;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;

/**
 * @title Products
 * @group products
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerImageTest extends BaseTest
{
    use AdditionalAssertions;

    public function test_a_guess_cannot_upload_any_image_to_any_product()
    {
        $response = $this->postJson(route('product.image', 1), []);

        $response->assertUnauthorized();
    }

    public function test_image_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'image',
            \App\Http\Requests\ProductImageRequest::class
        );
    }

    public function test_authenticated_seller_cannot_upload_image_with_invalid_orientation()
    {
        $store = $this->createStore($this->createAuthenticatedSeller());
        $product = $this->createProduct($store);

        $data = [
            'images' => [
                ['orientation' => 'invalid_orientation', 'file' => UploadedFile::fake()->image('plan.png')], // 3
            ],
        ];
        $response = $this->postJson(route('product.image', $product->id), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'images.0.orientation',
        ]);
    }

    public function test_authenticated_seller_cannot_upload_image_with_invalid_image()
    {
        $store = $this->createStore($this->createAuthenticatedSeller());
        $product = $this->createProduct($store);

        $data = [
            'images' => [
                ['orientation' => 'plan', 'file' => 'invalid_image'],
            ],
        ];
        $response = $this->postJson(route('product.image', $product->id), $data, $this->customHeaders());

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'images.0.file',
        ]);
    }

    public function test_authenticated_seller_can_store_a_product_with_only_required_info_and_images()
    {
        Storage::fake('s3');
        $store = $this->createStore($this->createAuthenticatedSeller());
        $product = $this->createProduct($store);

        $data = [
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')],
            ],
        ];
        $response = $this->postJson(route('product.image', $product->id), $data, $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'data' => $this->structure(),
            ]
        );
        $this->assertDatabaseCount('media', 4);
        $this->assertEquals(1, Media::featured()->count());
        $this->assertEquals(3, Media::nonFeatured()->count());
    }
}
