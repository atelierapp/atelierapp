<?php

namespace Tests\Feature\ShoppingCart;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShoppingCart;
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
        $coupon = Coupon::factory(['start_date' => '2020-01-01', 'end_date' => '2023-03-07'])->create();

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

    public function test_a_customer_can_create_an_order_and_coupon_dont_apply_if_today_is_less_than_start_date()
    {
        $user = $this->createAuthenticatedUser();

        ShoppingCart::factory()->create(['customer_id' => $user->id]);
        $coupon = Coupon::factory(['start_date' => now()->addMonth()])->create();

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

    public function test_a_customer_can_create_an_order_and_coupon_dont_apply_if_today_is_greater_than_end_date()
    {
        $user = $this->createAuthenticatedUser();

        ShoppingCart::factory()->create(['customer_id' => $user->id]);
        $coupon = Coupon::factory(['end_date' => now()->subMonth()])->create();

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

    public function test_a_customer_can_create_an_order_with_activated_fixed_total_coupon_and_save_use()
    {
        $user = $this->createAuthenticatedUser();
        $product = Product::factory(['price' => 100.00])->create();
        $variation = Variation::factory(['product_id' => $product->id])->create();
        ShoppingCart::factory()->create(['customer_id' => $user->id, 'variation_id' => $variation->id, 'quantity' => 1]);
        $coupon = Coupon::factory()->allActive()->fixed(20)->sellerMode($product->store_id)->create();

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
        $this->assertDatabaseHas('orders', [
            'store_id' => null,
            'user_id' => $user->id,
            'total_price' => 100,
            'discount_amount' => 20 * 100,
            'final_price' => 80 * 100,
        ]);
        $this->assertDatabaseHas('orders', [
            'store_id' => $variation->product->store_id,
            'user_id' => $user->id,
            'total_price' => 100,
            'discount_amount' => 20 * 100,
            'final_price' => 80 * 100,
        ]);
        $this->assertDatabaseHas('order_details', [
            'product_id' => $variation->product_id,
            'variation_id' => $variation->id,
            'unit_price' => $product->price,
            'quantity' => 1,
            'total_price' => $product->price,
            'discount_amount' => 20 * 100,
            'final_price' => 80 * 100,
        ]);
    }

    public function test_a_customer_can_create_an_order_with_activated_percent_total_coupon_and_save_use()
    {
    }

    public function test_a_customer_can_create_an_order_with_activated_fixed_seller_coupon_and_save_use()
    {
    }

    public function test_a_customer_can_create_an_order_with_activated_percent_seller_coupon_and_save_use()
    {
    }

    public function test_a_customer_can_create_an_order_with_activated_fixed_product_coupon_and_save_use()
    {
    }

    public function test_a_customer_can_create_an_order_with_activated_percent_product_coupon_and_save_use()
    {
    }

    public function test_a_costumer_can_create_an_order_with_activated_product_coupon_but_this_coupon_only_apply_to_1_product_of_all_product_of_shopping_cart()
    {
    }

    public function test_a_customer_can_create_an_order_without_product_coupon_dont_apply_if_any_product_of_shopping_cat_dont_match_with_any_available_product_of_coupon()
    {
    }
}
