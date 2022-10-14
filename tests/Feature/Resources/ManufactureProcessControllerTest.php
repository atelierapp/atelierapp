<?php

namespace Tests\Feature\Resources;

use Tests\TestCase;

class ManufactureProcessControllerTest extends TestCase
{
    public function test_a_guess_user_cannot_list_manufacture_process()
    {
        $response = $this->getJson(route('resources.manufacture-process'), $this->customHeaders());

        $response->assertUnauthorized();
    }

    public function test_a_admin_user_can_list_manufacture_process()
    {
        $this->createAuthenticatedAdmin();

        $response = $this->getJson(route('resources.manufacture-process'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
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
