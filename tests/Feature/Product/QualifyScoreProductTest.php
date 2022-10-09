<?php

namespace Tests\Feature\Product;

use App\Models\Product;

class QualifyScoreProductTest extends BaseTest
{
    public function test_when_product_has_many_qualifies()
    {
        $this->createAuthenticatedUser();
        $product = Product::factory()->pe()->create();

        $this->postJson(route('product.review.store', $product->id), [
            'score' => 3,
            'comment' => $this->faker->paragraph,
        ], $this->customHeaders());
        $this->postJson(route('product.review.store', $product->id), [
            'score' => 4,
            'comment' => $this->faker->paragraph,
        ], $this->customHeaders());
        $this->postJson(route('product.review.store', $product->id), [
            'score' => 5,
            'comment' => $this->faker->paragraph,
        ], $this->customHeaders());

        $this->assertEquals(4, $product->qualifications()->avg('score'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'score' => 4
        ]);
    }
}
