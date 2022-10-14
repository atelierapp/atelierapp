<?php

namespace Tests\Feature\Resources;

use Tests\TestCase;

class ManufactureTypeControllerTest extends TestCase
{
    public function test_a_guess_user_cannot_list_manufacture_types()
    {
        $response = $this->getJson(route('resources.manufacture-type'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_admin_user_can_list_manufacture_types()
    {
        $this->createAuthenticatedAdmin();

        $response = $this->getJson(route('resources.manufacture-type'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                ]
            ]
        ]);
    }
}
