<?php

namespace Tests\Feature\Profile;

use App\Models\FavoriteProduct;
use App\Models\Product;
use Tests\TestCase;

class ProfileFavoriteControllerTest extends TestCase
{
    public function test_a_guess_cannot_create_list_favorites(): void
    {
        $response = $this->getJson(route('profile.favorites'));

        $response->assertUnauthorized();
    }

    public function test_an_authenticated_app_user_can_list_favorites(): void
    {
        $user = $this->createAuthenticatedUser();
        Product::factory()->count(10)->create();
        $products = Product::inRandomOrder()->limit(4)->get();
        $products->each(fn ($prd) => FavoriteProduct::create(['user_id' => $user->id, 'product_id' => $prd->id]));

        $response = $this->getJson(route('profile.favorites'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(4, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'title',
                    'manufacturer_process',
                    'manufactured_at',
                    'description',
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
                ]
            ]
        ]);
    }

    public function test_an_authenticated_seller_user_can_list_favorites(): void
    {
        $user = $this->createAuthenticatedSeller();
        Product::factory()->count(10)->create();
        $products = Product::inRandomOrder()->limit(4)->get();
        $products->each(fn ($prd) => FavoriteProduct::create(['user_id' => $user->id, 'product_id' => $prd->id]));

        $response = $this->getJson(route('profile.favorites'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(4, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'title',
                    'manufacturer_process',
                    'manufactured_at',
                    'description',
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
                ]
            ]
        ]);
    }
}
