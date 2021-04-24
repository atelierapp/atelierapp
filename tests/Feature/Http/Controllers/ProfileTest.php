<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @title Profile
 * @package Tests\Feature\Http\Controllers
 */
class ProfileTest extends TestCase
{

    /**
     * @test
     * @title A user can access his/her info.
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
     * @title A guest can't access a profile info.
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
