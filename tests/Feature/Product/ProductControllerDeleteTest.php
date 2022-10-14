<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use function route;

/**
 * @title Products
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerDeleteTest extends BaseTest
{
    use RefreshDatabase;
    use WithFaker;
    use AdditionalAssertions;

    /**
     * @test
     * @title Delete product
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $store = $this->createStore($this->createAuthenticatedSeller());
        $product = $this->createProduct($store);

        $response = $this->deleteJson(route('product.destroy', $product), headers: $this->customHeaders());

        $response->assertNoContent();
        $this->assertSoftDeleted($product);
    }
}
