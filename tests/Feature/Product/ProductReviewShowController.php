<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductQualification;
use App\Models\Store;
use Tests\TestCase;

class ProductReviewShowController extends TestCase
{
    public function test_an_seller_user_can_reviews_from_specified_product()
    {
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['store_id' => $store->id]);
        ProductQualification::factory()->count(3)->create(['product_id' => $product->id]);

        $response = $this->getJson(route('product.review.show', $product->id));

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'user',
                    'product',
                    'score',
                    'comment',
                ],
            ],
        ]);
    }
}
