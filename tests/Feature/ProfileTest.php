<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileTest extends TestCase {

    /**
    * @test
    * Test for: a user can access his/her info.
    */
    public function a_user_can_access_his_her_info()
    {
        // Given an authenticated user
        $this->createAuthenticatedUser();
        // When the request is made
        $response = $this->getJson('/api/profile');
        // Then the expected data is returned
        $response->assertOk();
    }

    /**
    * @test
    * Test for: a guest cannot access his/her profile info.
    */
    public function a_guest_cannot_access_his_her_profile_info()
    {
        // Given an unauthorized call
        // When the request is made
        $response = $this->json('GET', '/api/profile');
        // Then the access is blocked
        $response->assertUnauthorized();
    }
}
