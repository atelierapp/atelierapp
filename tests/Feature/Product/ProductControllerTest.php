<?php

namespace Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

use function route;

/**
 * @title Products
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerTest extends TestCase
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
        $this->markTestSkipped();
        $product = Product::factory()->create();

        $response = $this->delete(route('product.destroy', $product));

        $response->assertNoContent();

        $this->assertSoftDeleted($product);
    }
}
