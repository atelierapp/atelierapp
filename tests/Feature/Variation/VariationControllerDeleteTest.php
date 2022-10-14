<?php

namespace Tests\Feature\Variation;

use App\Models\Variation;

class VariationControllerDeleteTest extends BaseTest
{
    public function test_a_guess_cannot_create_any_variation_of_any_product()
    {
        $response = $this->deleteJson(route('variation.destroy', ['product' => 1, 'variation' => 1]), [], $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_authenticated_normal_user_cannot_delete_any_variation_of_product()
    {
        $this->createAuthenticatedUser();

        $response = $this->deleteJson(route('variation.destroy', ['product' => 1, 'variation' => 1]), [], $this->customHeaders());

        $response->assertStatus(403);
    }

    public function test_a_authenticated_seller_user_can_delete_any_variation_of_product()
    {
        $product = $this->createProductForSellerUser();
        $variation = Variation::factory()->create(['product_id' => $product->id]);

        $data = ['product' => $product->id, 'variation' => $variation->id];
        $response = $this->deleteJson(route('variation.destroy', $data), [], $this->customHeaders());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('variations', $variation->toArray());
    }
}
