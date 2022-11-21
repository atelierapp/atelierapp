<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ShoppingCart;
use App\Models\Variation;
use Tests\TestCase;

class ShoppingCartControllerTest extends TestCase
{
    public function testReplace()
    {
        $variants = Variation::factory()->count(2)->create();

        $data = [
            [
                'variation_id' => $variation1 = $variants->first()->id,
                'quantity' => 3,
            ],
            [
                'variation_id' => $variants->last()->id,
                'quantity' => 5,
            ],
        ];

        $this->post(route('shopping-cart.replace'), $data, [
            'x-device-uuid' => $this->faker->uuid,
        ]);

        $this->assertDatabaseCount('shopping_cart', 2);
        $this->assertTrue(
            ShoppingCart::query()
                ->where('variation_id', $variation1)
                ->where('quantity', 3)
                ->exists()
        );
    }
}
