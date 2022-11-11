<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use Tests\TestCase;

class ProjectShoppingCartControllerTest extends TestCase
{
    public function test_a_guess_user_cannot_create_a_shopping_cart_from_project()
    {
        self::markTestSkipped();
        $response = $this->postJson(route('project.shopping-cart'));

        $response->assertUnauthorized();
    }

    public function test_an_app_user_can_create_a_shopping_cart_from_project()
    {
        self::markTestSkipped();
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->create(['author_id' => $user->id, 'forked_from_id' => null]);

        $response = $this->postJson(route('project.shopping-cart', $project->id), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [

            ]
        ]);
        $this->assertDatabaseHas('shopping_cart', [
            'user_id' => $user->id,
            'projet_id' => $project->id,
        ]);
    }
}
