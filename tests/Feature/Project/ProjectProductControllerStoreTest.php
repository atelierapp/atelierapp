<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use App\Models\Variation;
use Tests\TestCase;

class ProjectProductControllerStoreTest extends TestCase
{
    public function test_an_app_user_can_add_variation_to_his_project()
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->create(['author_id' => $user->id]);
        $variation = Variation::factory()->create();

        $data = [
            'variation_id' => $variation->id,
            'quantity' => $this->faker->numberBetween(1, 3),
        ];
        $response = $this->postJson(route('project.product.store', ['project' => $project->id]), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [

            ]
        ]);
        $this->assertDatabaseHas('product_project', [
            'project_id' => $project->id,
            'variation_id' => $variation->id,
            'product_id' => $variation->product_id,
            'quantity' => $data['quantity'],
        ]);
    }
}
