<?php

namespace Tests\Feature\Project;

use App\Models\ProductProject;
use App\Models\Project;

class ProjectProductControllerDeleteTest extends BaseTest
{
    public function test_an_app_user_can_list_product_from_project()
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->create(['author_id' => $user->id]);
        $item = ProductProject::factory()->create(['project_id' => $project->id]);

        $response = $this->deleteJson(route('project.product.delete', [
            'project' => $project->id,
            'variation' => $item->variation_id,
        ]));

        $response->assertOk();
        $response->assertJsonCount(0, 'data.products');
        $this->assertDatabaseMissing('product_project', [
            'project_id' => $project->id,
            'variation_id' => $item->variation_id
        ]);
    }
}
