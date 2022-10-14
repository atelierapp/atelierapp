<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductQualification;
use App\Models\Store;

class ProductReviewIndexController extends BaseTest
{
    public function test_an_seller_user_can_list_only_his_qualifications_product()
    {
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory()->create(['user_id' => $user->id]);
        Product::factory()->count(5)->create();
        ProductQualification::factory()->count(6)->create([
            'product_id' => Product::factory()->create(['store_id' => $store->id])->id,
        ]);

        $response = $this->getJson(route('product.review.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'product_id',
                    'product_id',
                    'score',
                    'comment',
                ],
            ],
        ]);
        $response->assertJsonCount(6, 'data');
    }
}
