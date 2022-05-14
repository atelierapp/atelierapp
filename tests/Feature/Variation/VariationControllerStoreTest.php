<?php

namespace Tests\Feature\Variation;

use App\Models\Product;
use Illuminate\Http\UploadedFile;

class VariationControllerStoreTest extends BaseTest
{
    public function test_a_guess_cannot_create_any_variation_of_any_product()
    {
        $response = $this->postJson(route('variation.store', 1), []);

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_create_any_variation_of_product()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('variation.store', 1), []);

        $response->assertStatus(403);
    }

    public function test_authenticated_seller_cannot_store_a_variation_without_minimum_required_info()
    {
        $this->createAuthenticatedSeller();

        $response = $this->postJson(route('variation.store', 1), []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'name',
            'images',
        ]);
    }

    public function test_authenticated_seller_cannot_store_a_variation_with_all_orientation_required_images()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')],
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')],
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('perspective.png')],
            ],
        ];
        $response = $this->postJson(route('variation.store', 1), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'images',
        ]);
    }

    public function test_authenticated_seller_cannot_store_a_variation_with_invalid_images_or_orientation()
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
        $response = $this->postJson(route('variation.store', 1), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'images.3.orientation',
            'images.2.file',
        ]);
    }

    public function test_authenticated_seller_cannot_store_a_variation_when_product_id_is_invalid()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')], // 1
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')], // 2
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('plan.png')], // 3
            ],
        ];
        $response = $this->postJson(route('variation.store', 123), $data);

        $response->assertNotFound();
    }

    public function test_authenticated_seller_cannot_store_a_variation_when_product_id_is_not_him()
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
        $response = $this->postJson(route('variation.store', $product->id), $data);

        $response->assertNotFound();
    }

    public function test_authenticated_seller_can_store_a_variation_with_valid_data_and_product_id()
    {
        $product = $this->createProductForSellerUser();

        $data = [
            'name' => $this->faker->name,
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')], // 1
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')], // 2
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('plan.png')], // 3
            ],
        ];
        $response = $this->postJson(route('variation.store', $product->id), $data);

        $response->assertCreated();
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
        $this->assertDatabaseCount('variations', 1);
    }
}
