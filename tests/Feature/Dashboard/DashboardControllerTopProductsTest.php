<?php

namespace Tests\Feature\Dashboard;

use App\Models\Product;

class DashboardControllerTopProductsTest extends Basetest
{
    public function test_an_guess_user_cannot_get_top_product()
    {
        $response = $this->getJson(route('dashboard.top-product'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_can_get_top_product()
    {
        $this->createAuthenticatedSeller();
        Product::factory()->count(10)->create();
        $response = $this->getJson(route('dashboard.top-product'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'image',
                    'name',
                    'availability',
                    'sales',
                ],
            ],
        ]);
    }
}
