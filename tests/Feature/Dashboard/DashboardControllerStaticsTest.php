<?php

namespace Tests\Feature\Dashboard;

class DashboardControllerStaticsTest extends Basetest
{
    public function test_an_guess_user_cannot_get_kpis()
    {
        $response = $this->getJson(route('dashboard.statics'));

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_can_get_statics()
    {
        $this->createAuthenticatedSeller();
        $response = $this->getJson(route('dashboard.statics'));
        
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'month',
                    'sales',
                    'views',
                ]
            ],
        ]);
    }
}
