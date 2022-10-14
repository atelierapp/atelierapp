<?php

namespace Profile;

use Tests\TestCase;

class ProfileControllerTermsTest extends TestCase
{
    public function test_an_guess_user_cannot_accept_terms()
    {
        $response = $this->postJson(route('profile.terms'));

        $response->assertUnauthorized();
    }

    public function test_an_app_user_cannot_accept_terms()
    {
        $this->createAuthenticatedUser();

        $response = $this->postJson(route('profile.terms'));

        $response->assertUnauthorized();
    }

    public function test_an_seller_user_can_accept_terms()
    {
        $user = $this->createAuthenticatedSeller();

        $response = $this->postJson(route('profile.terms'));

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_accepted_terms' => true
        ]);
    }
}
