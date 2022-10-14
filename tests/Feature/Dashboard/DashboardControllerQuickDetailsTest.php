<?php

namespace Tests\Feature\Dashboard;

class DashboardControllerQuickDetailsTest extends Basetest
{
    public function test_an_guess_user_cannot_get_quick_details()
    {
        $response = $this->getJson(route('dashboard.quick-details'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_can_get_quick_details()
    {
        $this->createAuthenticatedSeller();
        $response = $this->getJson(route('dashboard.quick-details'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'customers',
                'awaiting_orders',
                'on_hold_orders',
                'low_stock_orders',
                'out_stock_orders',
            ],
        ]);
    }
}
