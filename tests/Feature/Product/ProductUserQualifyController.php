<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductUserQualifyController extends TestCase
{
    public function test_a_guest_user_cannot_submit_any_product_qualification()
    {
        $response = $this->postJson(route('product.qualify', 1));

        $response->assertUnauthorized();
    }

    public function test_an_user_cannot_qualify_a_store_without_score_param()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('product.qualify', 1));

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['score']);
    }

    public function test_an_user_cannot_qualify_a_product_if_value_of_score_param_is_a_string()
    {
        $this->createAuthenticatedUser();

        $data = [
            'score' => $this->faker->word ,
        ];
        $response = $this->postJson(route('product.qualify', 1), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['score']);
    }

    public function test_an_user_cannot_qualify_a_product_if_value_of_score_param_is_zero()
    {
        $this->createAuthenticatedUser();

        $data = [
            'score' => 0,
        ];
        $response = $this->postJson(route('product.qualify', 1), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['score']);
    }

    public function test_an_user_cannot_qualify_a_product_if_value_is_greatest_than_five()
    {
        $this->createAuthenticatedUser();

        $data = [
            'score' => 8,
        ];
        $response = $this->postJson(route('product.qualify', 1), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['score']);
    }

    public function test_an_user_can_qualify_a_product_with_valid_params_and_without_files()
    {
        $this->createAuthenticatedUser();
        $product = Product::factory()->create();

        $data = [
            'score' => 4,
            'comment' => $this->faker->paragraph
        ];
        $response = $this->postJson(route('product.qualify', $product->id), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'score',
                'comment'
            ]
        ]);
        self::assertEquals($data['score'], $response->json('data.score'));
        self::assertEquals($data['comment'], $response->json('data.comment'));
        self::assertDatabaseCount('product_qualifications', 1);
    }

    public function test_an_user_can_qualify_a_product_with_valid_params_and_with_files()
    {
        Storage::fake('s3');
        $this->createAuthenticatedUser();
        $product = Product::factory()->create();

        $data = [
            'score' => 4,
            'comment' => $this->faker->paragraph,
            'attaches' => [
                UploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png'),
            ]
        ];
        $response = $this->postJson(route('product.qualify', $product->id), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'score',
                'comment',
                'attaches',
            ]
        ]);
        self::assertEquals($data['score'], $response->json('data.score'));
        self::assertEquals($data['comment'], $response->json('data.comment'));
        self::assertDatabaseCount('product_qualifications', 1);
        self::assertDatabaseCount('product_qualifications_files', 2);
    }
}
