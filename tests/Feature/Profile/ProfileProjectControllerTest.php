<?php

namespace Tests\Feature\Profile;

use App\Models\Project;
use Tests\TestCase;

class ProfileProjectControllerTest extends TestCase
{
    public function test_a_guess_cannot_list_projects(): void
    {
        $response = $this->getJson(route('profile.projects'));

        $response->assertUnauthorized();
    }

    public function test_auth_app_user_can_list_his_project(): void
    {
        $user = $this->createAuthenticatedUser();
        Project::factory()->count(3)->create(['author_id' => $user->id]);

        $response = $this->getJson(route('profile.projects'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                    'style_id',
                    'style',
                    'author_id',
                    'author',
                    'published',
                    'public',
                    'image',
                    'forked_from_id',
                    'tags',
                    'settings',
                ]
            ]
        ]);
    }
}
