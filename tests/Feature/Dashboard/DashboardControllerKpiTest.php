<?php

namespace Tests\Feature\Dashboard;

class DashboardControllerKpiTest extends Basetest
{
    public function test_an_guess_user_cannot_get_kpis()
    {
        $response = $this->getJson(route('dashboard.kpi'));

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_can_get_kpis()
    {
        $this->createAuthenticatedSeller();
        $response = $this->getJson(route('dashboard.kpi'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'views' => [
                    'value',
                    'percent',
                    'history',
                ],
                'products' => [
                    'value',
                    'percent',
                    'history',
                ],
                'earnings' => [
                    'value',
                    'percent',
                    'history',
                ],
            ],
        ]);
    }
}
