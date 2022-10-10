<?php

namespace Tests\Feature\Variation;

use App\Models\Variation;

class VariationControllerIndexTest extends BaseTest
{
    public function test_a_guess_cannot_list_any_variation_of_any_product()
    {
        $response = $this->getJson(route('variation.index', 1), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_authenticated_seller_can_list_variation_from_specified_product()
    {
        $product = $this->createProductForSellerUser();
        Variation::factory()->count(3)->create(['product_id' => $product->id]);

        $response = $this->getJson(route('variation.index', $product->id), $this->customHeaders());

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
