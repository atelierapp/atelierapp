<?php

namespace Tests\Feature\Variation;

use App\Models\Product;
use App\Models\Store;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    protected function createProductForSellerUser(): Product
    {
        return Product::factory()->pe()->create([
            'store_id' => Store::factory()->pe()->create([
                'user_id' => $this->createAuthenticatedSeller(['country' => 'pe'])->id
            ])->id,
        ]);
    }

}
