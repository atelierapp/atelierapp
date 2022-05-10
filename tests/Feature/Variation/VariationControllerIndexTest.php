<?php

namespace Tests\Feature\Variation;

use App\Models\Product;
use App\Models\Store;
use App\Models\Variation;
use Tests\TestCase;

class VariationControllerIndexTest extends TestCase
{
    private function createProduct(): Product
    {
        return Product::factory()->create([
            'store_id' => Store::factory()->create([
                'user_id' => $this->createAuthenticatedSeller()->id
            ])->id,
        ]);
    }

    public function test_a_guess_cannot_list_any_variation_of_any_product()
    {
        $response = $this->getJson(route('variation.index', 1), []);

        $response->assertUnauthorized();
    }

    public function test_an_authenticated_seller_can_list_variation_from_specified_product()
    {
        $product = $this->createProduct();
        Variation::factory()->count(3)->create(['product_id' => $product->id]);

        $response = $this->getJson(route('variation.index', $product->id));

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'name',
                ],
            ],
        ]);
    }
}
