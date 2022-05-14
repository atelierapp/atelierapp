<?php

namespace Tests\Feature\Variation;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VariationControllerImageTest extends BaseTest
{
    public function test_a_guess_cannot_upload_image_of_any_variation_of_any_product()
    {
        $response = $this->postJson(route('variation.image', ['product' => 1, 'variation' => 1]), []);

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_upload_image_of_any_variation_of_product()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('variation.image', ['product' => 1, 'variation' => 1]), []);

        $response->assertStatus(403);
    }

    public function test_authenticated_seller_cannot_upload_image_to_variation_with_invalid_images_or_orientation()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'images' => [
                ['orientation' => 'plan', 'file' => 'invalid_image'], // 0
                ['orientation' => 'invalid_orientation', 'file' => UploadedFile::fake()->image('plan.png')], // 1
            ],
        ];
        $response = $this->postJson(route('variation.image', ['product' => 1, 'variation' => 1]), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'images.0.file',
            'images.1.orientation',
        ]);
    }

    public function test_authenticated_seller_cannot_upload_image_to_variation_when_product_id_is_invalid()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
            ],
        ];
        $response = $this->postJson(route('variation.image', ['product' => 999, 'variation' => 1]), $data);

        $response->assertNotFound();
    }

    public function test_authenticated_seller_cannot_upload_a_variation_when_product_id_invalid_but_variation_is_invalid()
    {
        $product = $this->createProductForSellerUser();

        $data = [
            'name' => $this->faker->name,
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
            ],
        ];
        $response = $this->postJson(route('variation.image', ['product' => $product->id, 'variation' => 123]), $data);

        $response->assertNotFound();
    }

    public function test_authenticated_seller_cannot_upload_image_product_a_variation_when_product_id_is_not_him_or_invalid()
    {
        $this->createAuthenticatedSeller();
        $product = Product::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')], // 1
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')], // 2
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('plan.png')], // 3
            ],
        ];
        $response = $this->postJson(route('variation.image', ['product' => $product->id, 'variation' => 123]), $data);

        $response->assertNotFound();
    }

    public function test_authenticated_seller_can_upload_image_to_variation_with_valid_image_when_product_id_and_variation_id_is_valid()
    {
        Storage::fake('s3');
        $product = $this->createProductForSellerUser();
        $variation = Variation::factory()->create(['product_id' => $product->id]);

        $data = [
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')], // 1
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')], // 2
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('plan.png')], // 3
            ],
        ];
        $response = $this->postJson(route('variation.image', ['product' => $product->id, 'variation' => $variation->id]), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'name',
                'medias' => [
                    0 => [
                        'id',
                        'orientation',
                        'url',
                    ]
                ]
            ]
        ]);
        $this->assertDatabaseCount('media', 4);
    }
}
