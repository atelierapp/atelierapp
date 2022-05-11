<?php

namespace Tests\Feature\Variation;

use App\Models\Product;
use App\Models\Store;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    protected function createProductForSellerUser(): Product
    {
        return Product::factory()->create([
            'store_id' => Store::factory()->create([
                'user_id' => $this->createAuthenticatedSeller()->id
            ])->id,
        ]);
    }

}
