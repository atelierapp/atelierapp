<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use App\Models\StoreUserRating;
use Tests\TestCase;

class ProcessUserRatingCommandTest extends TestCase
{
    public function test_that_a_store_has_a_customer_rating_greater_than_one_when_it_has_more_than_fifteen_rating()
    {
        $store = $this->generateStoreComments(20);
        $rating = StoreUserRating::whereStoreId($store->id)->avg('score');

        $this->artisan('process:user-rating');

        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'customer_rating' => ($rating * 100)
        ]);
    }
    public function test_that_a_store_has_a_customer_rating_equal_to_zero_greater_when_it_not_has_more_than_fifteen_rating()
    {
        $store = $this->generateStoreComments(8);
        $rating = StoreUserRating::whereStoreId($store->id)->avg('score');

        $this->artisan('process:user-rating');

        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'customer_rating' => 0
        ]);
    }

    private function generateStoreComments($ratings = 15): Store
    {
        return Store::factory()
            ->has(StoreUserRating::factory()->count($ratings), 'userRatings')
            ->create([
                'customer_rating' => 0,
            ]);
    }
}
