<?php

namespace Tests\Feature\ShoppingCart;

use App\Models\Order;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\Store;
use App\Models\Variation;
use Database\Seeders\OrderStatusSeeder;
use Database\Seeders\PaymentStatusSeeder;

class CreateOrderTest extends BaseTest
{
    public function test_cannot_create_an_order_for_guess_user(): void
    {
        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertUnauthorized();
    }

    public function test_cannot_create_an_order_if_shopping_cart_is_empty(): void
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'code',
            'message',
            'errors',
        ]);
    }

    public function test_can_create_an_order_from_shopping_cart_when_it_has_one_product(): void
    {
        $this->seed([OrderStatusSeeder::class, PaymentStatusSeeder::class]);
        $user = $this->createAuthenticatedUser();

        ShoppingCart::factory()->create([
            'customer_id' => $user->id,
        ]);

        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertGreaterThan(1, Order::where('total_price', '>', '1')->sum('total_price'));
        $this->assertGreaterThan(1, Order::where('total_revenue', '>', '1')->sum('total_revenue'));
    }

    public function test_can_create_an_order_from_shopping_cart_when_it_has_one_product_with_fixed_discount(): void
    {
        $this->seed([OrderStatusSeeder::class, PaymentStatusSeeder::class]);
        $user = $this->createAuthenticatedUser();
        $store = Store::factory()->active()->create(['user_id' => $user->id]);
        $product = Product::factory()->withFixedDiscount(20)->create([
            'price' => 100,
            'store_id' => $store->id,
        ]);
        $variation = Variation::factory()->create(['product_id' => $product->id]);
        ShoppingCart::factory()->create([
            'customer_id' => $user->id,
            'variation_id' => $variation,
            'quantity' => 1,
        ]);

        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertGreaterThan(1, Order::where('total_revenue', '>', '1')->sum('total_revenue'));
        $this->assertDatabaseHas('orders', [
            'total_price' => 80
        ]);
    }

    public function test_can_create_an_order_from_shopping_cart_when_it_has_many_products_with_fixed_discount(): void
    {
        $this->seed([OrderStatusSeeder::class, PaymentStatusSeeder::class]);
        $user = $this->createAuthenticatedUser();
        $store = Store::factory()->active()->create(['user_id' => $user->id]);
        $product = Product::factory()->withFixedDiscount(20)->create([
            'price' => 100,
            'store_id' => $store->id,
        ]);
        $product2 = Product::factory()->withFixedDiscount(50)->create([
            'price' => 150,
            'store_id' => $store->id,
        ]);
        $variation1 = Variation::factory()->create(['product_id' => $product->id]);
        $variation2 = Variation::factory()->create(['product_id' => $product2->id]);
        ShoppingCart::factory()->create([
            'customer_id' => $user->id,
            'variation_id' => $variation1,
            'quantity' => 1,
        ]);
        ShoppingCart::factory()->create([
            'customer_id' => $user->id,
            'variation_id' => $variation2,
            'quantity' => 1,
        ]);

        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertGreaterThan(1, Order::where('total_revenue', '>', '1')->sum('total_revenue'));
        $this->assertDatabaseHas('orders', [
            'total_price' => (80 + 100)
        ]);
    }

    public function test_can_create_an_order_from_shopping_cart_when_it_has_one_product_with_percent_discount(): void
    {
        $this->seed([OrderStatusSeeder::class, PaymentStatusSeeder::class]);
        $user = $this->createAuthenticatedUser();
        $store = Store::factory()->active()->create(['user_id' => $user->id]);
        $product = Product::factory(['price' => 95,])->withPercentDiscount(15)->create([
            'store_id' => $store->id,
        ]);
        $variation = Variation::factory()->create(['product_id' => $product->id]);
        ShoppingCart::factory()->create([
            'customer_id' => $user->id,
            'variation_id' => $variation,
            'quantity' => 1,
        ]);

        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertGreaterThan(1, Order::where('total_revenue', '>', '1')->sum('total_revenue'));
        $this->assertDatabaseHas('orders', [
            'total_price' => 80.75
        ]);
    }

    public function test_can_create_an_order_from_shopping_cart_when_it_has_many_products_with_percent_discount(): void
    {
        $this->seed([OrderStatusSeeder::class, PaymentStatusSeeder::class]);
        $user = $this->createAuthenticatedUser();
        $store = Store::factory()->active()->create(['user_id' => $user->id]);
        $product = Product::factory(['price' => 100])->withPercentDiscount(20)->create([
            'store_id' => $store->id,
        ]);
        $product2 = Product::factory(['price' => 150])->withPercentDiscount(50)->create([
            'store_id' => $store->id,
        ]);
        $variation1 = Variation::factory()->create(['product_id' => $product->id]);
        $variation2 = Variation::factory()->create(['product_id' => $product2->id]);
        ShoppingCart::factory()->create([
            'customer_id' => $user->id,
            'variation_id' => $variation1,
            'quantity' => 1,
        ]);
        ShoppingCart::factory()->create([
            'customer_id' => $user->id,
            'variation_id' => $variation2,
            'quantity' => 1,
        ]);

        $response = $this->postJson(route('shopping-cart.order'));

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertGreaterThan(1, Order::where('total_revenue', '>', '1')->sum('total_revenue'));
        $this->assertDatabaseHas('orders', [
            'total_price' => 155
        ]);
    }
}
