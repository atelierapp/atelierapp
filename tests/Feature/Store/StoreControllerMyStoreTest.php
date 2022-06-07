<?php

namespace Tests\Feature\Store;

use App\Models\Store;

/**
 * @title Stores
 * @group stores
 * @see \App\Http\Controllers\StoreController
 */
class StoreControllerMyStoreTest extends BaseTest
{
    public function test_a_guess_user_cannot_show_any_store()
    {
        $response = $this->getJson(route('store.my-store'));

        $response->assertUnauthorized();
    }

    public function test_a_seller_user_can_view_his_store()
    {
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory(['user_id' => $user->id])->create();

        $response = $this->getJson(route('store.my-store'));

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
        $this->assertEquals($store->id, $response->json('data.id'));
    }

}
