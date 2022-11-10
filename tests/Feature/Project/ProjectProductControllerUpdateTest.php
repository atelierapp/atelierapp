<?php

namespace Tests\Feature\Project;

use App\Models\ProductProject;
use App\Models\Project;

class ProjectProductControllerUpdateTest extends BaseTest
{
    public function test_an_app_user_can_update_variation_for_specified_project()
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->create(['author_id' => $user->id]);
        $item = ProductProject::factory()->create(['project_id' => $project->id]);

        $data = [
            'quantity' => $this->faker->numberBetween(1, 3),
        ];
        $response = $this->patchJson(route('project.product.update', [
            'project' => $project->id,
            'variation' => $item->variation_id,
        ]), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $response->assertJsonStructure([
            'data' => [
                'products' => [
                    0 => $this->structureProduct(),
                ],
            ],
        ]);
        $this->assertDatabaseHas('product_project', [
            'variation_id' => $item->variation_id,
            'quantity' => $data['quantity']
        ]);
    }
}
