<?php

namespace Tests\Feature\ShoppingCart;

use App\Models\Coupon;
use App\Models\CouponDetail;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\Store;
use App\Models\Variation;

class CreateOrderWithCouponTest extends BaseTest
{
    // notes: for process the app user or web user will called "customer"

    public function test_a_customer_can_create_an_order_without_coupon_if_it_is_not_exists()
    {
        $user = $this->createAuthenticatedUser();

        ShoppingCart::factory()->create([
            'customer_id' => $user->id,
        ]);

        $data = [
            'coupon' => 'not-exists',
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseCount('coupon_uses', 0);
    }

    public function test_a_customer_can_create_an_order_and_coupon_dont_apply_if_coupon_reached_the_limit_of_allowed_uses()
    {
        $user = $this->createAuthenticatedUser();

        ShoppingCart::factory()->create(['customer_id' => $user->id]);
        $coupon = Coupon::factory(['max_uses' => '10', 'current_uses' => '10'])->create();

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseCount('coupon_uses', 0);
    }

    public function test_a_customer_can_create_an_order_and_coupon_dont_apply_if_the_current_date_dont_between_on_validation_dates()
    {
        $user = $this->createAuthenticatedUser();

        ShoppingCart::factory()->create(['customer_id' => $user->id]);
        $coupon = Coupon::factory(['start_date' => '2020-01-01', 'end_date' => '2023-03-07', 'current_uses' => 0])->create();

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseCount('coupon_uses', 0);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 0
        ]);
    }

    public function test_a_customer_can_create_an_order_and_coupon_dont_apply_if_today_is_less_than_start_date()
    {
        $user = $this->createAuthenticatedUser();

        ShoppingCart::factory()->create(['customer_id' => $user->id]);
        $coupon = Coupon::factory(['start_date' => now()->addMonth(), 'current_uses' => 0])->create();

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseCount('coupon_uses', 0);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 0
        ]);
    }

    public function test_a_customer_can_create_an_order_and_coupon_dont_apply_if_today_is_greater_than_end_date()
    {
        $user = $this->createAuthenticatedUser();

        ShoppingCart::factory()->create(['customer_id' => $user->id]);
        $coupon = Coupon::factory(['end_date' => now()->subMonth(), 'current_uses' => 0])->create();

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseCount('coupon_uses', 0);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 0
        ]);
    }

    public function test_a_customer_can_create_an_order_with_activated_fixed_total_coupon_and_save_use()
    {
        $user = $this->createAuthenticatedUser();
        $product = Product::factory(['price' => 10000])->create();
        $variation = Variation::factory(['product_id' => $product->id])->create();
        ShoppingCart::factory()->create(['customer_id' => $user->id, 'variation_id' => $variation->id, 'quantity' => 1]);
        $coupon = Coupon::factory()->allActive()->fixed(20)->totalMode()->create();

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseCount('coupon_uses', 1);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 1
        ]);
        $this->assertDatabaseHas('orders', [
            'store_id' => null,
            'user_id' => $user->id,
            'total_price' => 10000,
            'discount_amount' => 2000,
            'final_price' => 8000,
        ]);
        $this->assertDatabaseHas('orders', [
            'store_id' => $variation->product->store_id,
            'user_id' => $user->id,
            'total_price' => 10000,
            'discount_amount' => 2000,
            'final_price' => 8000,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $variation->product_id,
            'variation_id' => $variation->id,
            'unit_price' => $product->price,
            'quantity' => 1,
            'total_price' => $product->price,
            'discount_amount' => 2000,
            'final_price' => 8000,
        ]);
    }

    public function test_a_customer_can_create_an_order_with_activated_percent_total_coupon_and_save_use()
    {
        $user = $this->createAuthenticatedUser();
        $product = Product::factory(['price' => 7500])->create();
        $variation = Variation::factory(['product_id' => $product->id])->create();
        ShoppingCart::factory()->create(['customer_id' => $user->id, 'variation_id' => $variation->id, 'quantity' => 1]);
        $coupon = Coupon::factory()->allActive()->percent(20)->totalMode()->create();

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseCount('coupon_uses', 1);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 1
        ]);
        $this->assertDatabaseHas('orders', [
            'store_id' => null,
            'user_id' => $user->id,
            'total_price' => 7500,
            'discount_amount' => 1500,
            'final_price' => 6000,
        ]);
        $this->assertDatabaseHas('orders', [
            'store_id' => $variation->product->store_id,
            'user_id' => $user->id,
            'total_price' => 7500,
            'discount_amount' => 1500,
            'final_price' => 6000,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $variation->product_id,
            'variation_id' => $variation->id,
            'unit_price' => $product->price,
            'quantity' => 1,
            'total_price' => $product->price,
            'discount_amount' => 1500,
            'final_price' => 6000,
        ]);
    }

    public function test_a_customer_can_create_an_order_with_activated_fixed_seller_coupon_and_save_use()
    {
        $user = $this->createAuthenticatedUser();
        $product = Product::factory(['price' => 8500])->create();
        $coupon = Coupon::factory()->allActive()->percent(12)->sellerMode($product->store_id)->create();
        $variation = Variation::factory(['product_id' => $product->id])->create();
        ShoppingCart::factory()->create(['customer_id' => $user->id, 'variation_id' => $variation->id, 'quantity' => 1]);
        $variation2 = Variation::factory(['product_id' => Product::factory(['price' => 10000])])->create();
        ShoppingCart::factory()->create(['customer_id' => $user->id, 'variation_id' => $variation2->id, 'quantity' => 1]);

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 3);
        $this->assertDatabaseCount('coupon_uses', 1);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 1
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => null,
            'total_price' => 18500,
            'discount_amount' => 1020,
            'final_price' => 17480,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => $variation->product->store_id,
            'total_price' => 8500,
            'discount_amount' => 1020,
            'final_price' => 7480,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $variation->product_id,
            'variation_id' => $variation->id,
            'unit_price' => $product->price,
            'quantity' => 1,
            'total_price' => 8500,
            'discount_amount' => 1020,
            'final_price' => 7480,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => $variation2->product->store_id,
            'total_price' => 10000,
            'discount_amount' => 0,
            'final_price' => 10000,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $variation2->product_id,
            'variation_id' => $variation2->id,
            'unit_price' => 10000,
            'quantity' => 1,
            'total_price' => 10000,
            'discount_amount' => 0,
            'final_price' => 10000,
        ]);
    }

    public function test_a_customer_can_create_an_order_with_activated_percent_seller_coupon_and_save_use()
    {
        $user = $this->createAuthenticatedUser();
        $product = Product::factory(['price' => 8500])->create();
        $coupon = Coupon::factory()->allActive()->fixed(35)->sellerMode($product->store_id)->create();
        $variation = Variation::factory(['product_id' => $product->id])->create();
        ShoppingCart::factory()->create(['customer_id' => $user->id, 'variation_id' => $variation->id, 'quantity' => 1]);
        $variation2 = Variation::factory(['product_id' => Product::factory(['price' => 10000])])->create();
        ShoppingCart::factory()->create(['customer_id' => $user->id, 'variation_id' => $variation2->id, 'quantity' => 1]);

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 3);
        $this->assertDatabaseCount('coupon_uses', 1);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 1
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => null,
            'total_price' => 18500,
            'discount_amount' => 3500,
            'final_price' => 15000,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => $variation->product->store_id,
            'total_price' => 8500,
            'discount_amount' => 3500,
            'final_price' => 5000,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => $variation2->product->store_id,
            'total_price' => 10000,
            'discount_amount' => 0,
            'final_price' => 10000,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $variation->product_id,
            'variation_id' => $variation->id,
            'unit_price' => $product->price,
            'quantity' => 1,
            'total_price' => 8500,
            'discount_amount' => 3500,
            'final_price' => 5000,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $variation2->product_id,
            'variation_id' => $variation2->id,
            'unit_price' => 10000,
            'quantity' => 1,
            'total_price' => 10000,
            'discount_amount' => 0,
            'final_price' => 10000,
        ]);
    }

    public function test_a_customer_can_create_an_order_with_activated_fixed_product_coupon_and_save_use()
    {
        $user = $this->createAuthenticatedUser();
        $store = Store::factory(['active' => true])->create();
        $coupon = Coupon::factory(['current_uses' => 0])->allActive()->productMode($store->id)->fixed(15)->create();

        $product = Product::factory(['store_id' => $store->id, 'price' => 8500])->create();
        $product2 = Product::factory(['store_id' => $store->id, 'price' => 10000])->create();
        CouponDetail::create(['coupon_id' => $coupon->id, 'model_id' => $product->id, 'model_type' => Product::class]);
        ShoppingCart::factory()->product($product)->create(['customer_id' => $user->id, 'quantity' => 1]);
        ShoppingCart::factory()->product($product2)->create(['customer_id' => $user->id, 'quantity' => 1]);
        $cart = ShoppingCart::factory()->create(['customer_id' => $user->id, 'quantity' => 1]);

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 3);
        $this->assertDatabaseCount('coupon_uses', 1);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 1
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => null,
            'total_price' => 18500 + $cart->variation->product->price,
            'discount_amount' => 1500,
            'final_price' => 17000 + $cart->variation->product->price,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => $product->store_id,
            'total_price' => 18500,
            'discount_amount' => 1500,
            'final_price' => 17000,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => $cart->variation->product->store_id,
            'total_price' => $cart->variation->product->price,
            'discount_amount' => 0,
            'final_price' => $cart->variation->product->price,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $product->id,
            'unit_price' => $product->price,
            'quantity' => 1,
            'total_price' => $product->price,
            'discount_amount' => 1500,
            'final_price' => 7000,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $product2->id,
            'unit_price' => $product2->price,
            'quantity' => 1,
            'total_price' => $product2->price,
            'discount_amount' => 0,
            'final_price' => $product2->price,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $cart->variation->product->id,
            'unit_price' => $cart->variation->product->price,
            'quantity' => 1,
            'total_price' => $cart->variation->product->price,
            'discount_amount' => 0,
            'final_price' => $cart->variation->product->price,
        ]);
    }

    public function test_a_customer_can_create_an_order_with_activated_percent_product_coupon_and_save_use()
    {
        $user = $this->createAuthenticatedUser();
        $store = Store::factory(['active' => true])->create();
        $coupon = Coupon::factory()->allActive()->productMode($store->id)->percent(15)->create();

        $product = Product::factory(['store_id' => $store->id, 'price' => 8500])->create();
        $product2 = Product::factory(['store_id' => $store->id, 'price' => 10000])->create();
        CouponDetail::create(['coupon_id' => $coupon->id, 'model_id' => $product->id, 'model_type' => Product::class]);
        ShoppingCart::factory()->product($product)->create(['customer_id' => $user->id, 'quantity' => 1]);
        ShoppingCart::factory()->product($product2)->create(['customer_id' => $user->id, 'quantity' => 1]);
        $cart = ShoppingCart::factory()->create(['customer_id' => $user->id, 'quantity' => 1]);

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 3);
        $this->assertDatabaseCount('coupon_uses', 1);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 1
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => null,
            'total_price' => 18500 + $cart->variation->product->price,
            'discount_amount' => 1275,
            'final_price' => 17225 + $cart->variation->product->price,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => $product->store_id,
            'total_price' => 18500,
            'discount_amount' => 1275,
            'final_price' => 17225,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'store_id' => $cart->variation->product->store_id,
            'total_price' => $cart->variation->product->price,
            'discount_amount' => 0,
            'final_price' => $cart->variation->product->price,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $product->id,
            'unit_price' => $product->price,
            'quantity' => 1,
            'total_price' => $product->price,
            'discount_amount' => 1275,
            'final_price' => 7225,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $product2->id,
            'unit_price' => $product2->price,
            'quantity' => 1,
            'total_price' => $product2->price,
            'discount_amount' => 0,
            'final_price' => $product2->price,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $cart->variation->product->id,
            'unit_price' => $cart->variation->product->price,
            'quantity' => 1,
            'total_price' => $cart->variation->product->price,
            'discount_amount' => 0,
            'final_price' => $cart->variation->product->price,
        ]);
    }

    public function test_a_customer_can_create_an_order_without_product_coupon_dont_apply_if_any_product_of_shopping_cat_dont_match_with_any_available_product_of_coupon()
    {
        $user = $this->createAuthenticatedUser();
        $store = Store::factory(['active' => true])->create();
        $coupon = Coupon::factory()->allActive()->productMode($store->id)->percent(15)->create();
        $product = Product::factory(['store_id' => $store->id, 'price' => 8500])->create();
        CouponDetail::create(['coupon_id' => $coupon->id, 'model_id' => $product->id, 'model_type' => Product::class]);

        ShoppingCart::factory()->create(['customer_id' => $user->id, 'quantity' => 1]);
        ShoppingCart::factory()->create(['customer_id' => $user->id, 'quantity' => 1]);

        $data = [
            'coupon' => $coupon->code,
        ];
        $response = $this->postJson(route('shopping-cart.order'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'order_id',
            'links' => [
                'to_pay',
                'method',
            ],
        ]);
        $this->assertDatabaseCount('orders', 3);
        $this->assertDatabaseCount('coupon_uses', 0);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'current_uses' => 0
        ]);
    }
}
