<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\Store;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    use AdditionalAssertions;

    protected function createStore($user): Store
    {
        return Store::factory()->active()->create([
            'user_id' => $user->id,
        ]);
    }

    protected function createProduct($store): Product
    {
        return Product::factory()->create([
            'store_id' => $store->id,
        ]);
    }

    public static function structure(): array
    {
        return [
            'id',
            'title',
            'manufacturer_process',
            'manufactured_at',
            'description',
            'score',
            'price',
            'style_id',
            'style',
            'quantity',
            'sku',
            'active',
            'properties',
            'featured_media',
            'url',
            'is_on_demand',
            'is_unique',
            'has_discount',
            'is_discount_fixed',
            'discount_value',
            'discounted_amount',
            'final_price',
        ];
    }
}
