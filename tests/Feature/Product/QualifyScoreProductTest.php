<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Tests\TestCase;

class QualifyScoreProductTest extends TestCase
{
    public function test_when_product_has_many_qualifies()
    {
        $this->createAuthenticatedUser();
        $product = Product::factory()->create();

        $this->postJson(route('product.review.store', $product->id), [
            'score' => 3,
            'comment' => $this->faker->paragraph,
        ]);
        $this->postJson(route('product.review.store', $product->id), [
            'score' => 4,
            'comment' => $this->faker->paragraph,
        ]);
        $this->postJson(route('product.review.store', $product->id), [
            'score' => 5,
            'comment' => $this->faker->paragraph,
        ]);

        $this->assertEquals(4, $product->qualifications()->avg('score'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'score' => 4
        ]);
    }
}
