<?php

namespace Tests\Feature\Variation;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VariationControllerUpdateTest extends BaseTest
{
    public function test_a_guess_cannot_update_any_variation_of_any_product()
    {
        $response = $this->patchJson(route('variation.update', ['product' => 1, 'variation' => 1]), []);

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_any_update_variation_of_product()
    {
        $this->createAuthenticatedUser();

        $response = $this->patchJson(route('variation.update', ['product' => 1, 'variation' => 1]), []);

        $response->assertStatus(403);
    }

    public function test_authenticated_seller_cannot_update_a_variation_without_minimum_required_info()
    {
        $this->createAuthenticatedSeller();

        $response = $this->patchJson(route('variation.update', ['product' => 1, 'variation' => 1]), []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'name',
        ]);
    }

    public function test_authenticated_seller_cannot_update_a_variation_with_invalid_images_or_orientation()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'images' => [
                ['orientation' => 'plan', 'file' => 'invalid_image'], // 0
                ['orientation' => 'invalid_orientation', 'file' => UploadedFile::fake()->image('plan.png')], // 1
            ],
        ];
        $response = $this->patchJson(route('variation.update', ['product' => 1, 'variation' => 1]), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'images.0.file',
            'images.1.orientation',
        ]);
    }

    public function test_authenticated_seller_cannot_update_a_variation_when_product_id_is_invalid()
    {
        $this->createAuthenticatedSeller();

        $data = [
            'name' => $this->faker->name,
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
            ],
        ];
        $response = $this->patchJson(route('variation.update', ['product' => 999, 'variation' => 1]), $data);

        $response->assertNotFound();
    }

    public function test_authenticated_seller_cannot_update_a_variation_when_product_id_invalid_but_variation_is_invalid()
    {
        $product = $this->createProductForSellerUser();

        $data = [
            'name' => $this->faker->name,
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
            ],
        ];
        $response = $this->patchJson(route('variation.update', ['product' => $product->id, 'variation' => 123]), $data);

        $response->assertNotFound();
    }

    public function test_authenticated_seller_cannot_product_a_variation_when_product_id_is_not_him_or_invalid()
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
        $response = $this->patchJson(route('variation.update', ['product' => $product->id, 'variation' => 123]), $data);

        $response->assertNotFound();
    }

    public function test_authenticated_seller_can_update_a_variation_with_valid_name_data_product_id_and_variation_id()
    {
        $product = $this->createProductForSellerUser();
        $variation = Variation::factory()->create(['product_id' => $product->id]);

        $data = [
            'name' => $this->faker->name,
        ];
        $response = $this->patchJson(route('variation.update', ['product' => $product->id, 'variation' => $variation->id]), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'name',
            ]
        ]);
        $this->assertDatabaseHas('variations', [
            'id' => $variation->id,
            'name' => $data['name'],
        ]);
    }

    public function test_authenticated_seller_can_update_a_variation_with_valid_all_data_product_id_and_variation_id()
    {
        Storage::fake('s3');
        $product = $this->createProductForSellerUser();
        $variation = Variation::factory()->create(['product_id' => $product->id]);

        $data = [
            'name' => $this->faker->name,
            'images' => [
                ['orientation' => 'front', 'file' => UploadedFile::fake()->image('front.png')], // 0
                ['orientation' => 'side', 'file' => UploadedFile::fake()->image('side.png')], // 1
                ['orientation' => 'plan', 'file' => UploadedFile::fake()->image('plan.png')], // 2
                ['orientation' => 'perspective', 'file' => UploadedFile::fake()->image('plan.png')], // 3
            ],
        ];
        $response = $this->patchJson(route('variation.update', ['product' => $product->id, 'variation' => $variation->id]), $data);

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
        $this->assertDatabaseHas('variations', [
            'id' => $variation->id,
            'name' => $data['name'],
        ]);
        $this->assertDatabaseCount('media', 4);
    }
}
