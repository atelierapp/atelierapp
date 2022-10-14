<?php

namespace Tests\Feature\Dashboard;

class DashboardControllerKpiProductTest extends Basetest
{
    public function test_an_guess_user_cannot_get_products_kpis()
    {
        $response = $this->getJson(route('dashboard.kpi-products'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_can_get_products_kpis()
    {
        $this->createAuthenticatedSeller();
        $response = $this->getJson(route('dashboard.kpi-products'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'total_revenue',
                'revenue',
                'growth'
            ],
        ]);
    }
}
