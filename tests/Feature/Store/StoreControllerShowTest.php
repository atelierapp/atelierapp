<?php

namespace Tests\Feature\Store;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreControllerShowTest extends TestCase
{
    private function structure(): array
    {
        return [
            'id',
            'name',
            // 'legal_name',
            // 'legal_id',
            'story',
            'logo',
            'cover',
            'team',
            'active',
        ];
    }

    public function test_a_guess_user_cannot_show_any_store()
    {
        $response = $this->getJson(route('store.show', 1));

        $response->assertUnauthorized();
    }

    public function test_a_admin_user_can_view_a_specified_store()
    {
        $store = Store::factory()->create();
        $this->createAuthenticatedAdmin();

        $response = $this->getJson(route('store.show', $store));

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
    }

    public function test_a_seller_user_only_can_view_his_store()
    {
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory(['user_id' => $user->id])->create();

        $response = $this->getJson(route('store.show', $store->id));

        $response->assertOk();
        $response->assertJsonStructure(['data' => $this->structure()]);
    }

    public function test_a_seller_user_cannot_a_store_if_not_him()
    {
        $user = $this->createAuthenticatedSeller();
        $store = Store::factory()->create();

        $response = $this->getJson(route('store.show', $store->id));

        $response->assertNotFound();
    }
}
