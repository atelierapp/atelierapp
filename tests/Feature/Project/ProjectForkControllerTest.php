<?php

namespace Tests\Feature\Project;

use App\Models\Media;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;

class ProjectForkControllerTest extends BaseTest
{
    use AdditionalAssertions;
    use WithFaker;

    public function test_update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectForkController::class,
            '__invoke',
            \App\Http\Requests\ProjectForkRequest::class
        );
    }

    public function test_a_user_can_fork_someone_else_project_that_is_public_and_published_without_params(): void
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->hasTags(3)->create([
            'published' => true,
            'public' => true
        ]);

        $response = $this->postJson(route('projects.fork', $project->id));

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $response->assertJsonStructure([
            'data' => [
                'forkedFrom' => $this->structure(),
            ],
        ]);
        $this->assertDatabaseHas('projects', [
            'name' => $project->name . ' (forked)',
            'style_id' => $project->style_id,
            'author_id' => $user->id,
            'forked_from_id' => $project->id,
            'published' => false,
            'public' => false
        ]);
        $this->assertDatabaseCount('tags', 3);
        $projectTags = \DB::table('taggables')->where('taggable_id', $response->json('data.id'))->where('taggable_type', Project::class)->count();
        $this->assertEquals(3, $projectTags);
    }

    public function test_a_user_cannot_fork_someone_else_project_that_is_not_public_or_not_published(): void
    {
        $this->createAuthenticatedUser();
        $project = Project::factory()->create([
            'published' => false,
            'public' => false,
            'forked_from_id' => null,
        ]);

        $response = $this->postJson(route('projects.fork', $project->id));

        $response->assertStatus(403);
        $this->assertDatabaseCount('projects', 1);
    }

    public function test_a_user_can_fork_someone_else_project_that_is_public_and_published_with_name_param(): void
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->hasTags(3)->create([
            'published' => true,
            'public' => true
        ]);

        $data = [
            'name' => $this->faker()->name
        ];
        $response = $this->postJson(route('projects.fork', $project->id), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $response->assertJsonStructure([
            'data' => [
                'forkedFrom' => $this->structure(),
            ],
        ]);
        $this->assertDatabaseHas('projects', [
            'name' => $data['name'] . ' (forked)',
            'style_id' => $project->style_id,
            'author_id' => $user->id,
            'forked_from_id' => $project->id,
            'published' => false,
            'public' => false
        ]);
        $this->assertDatabaseCount('tags', 3);
        $projectTags = \DB::table('taggables')->where('taggable_id', $response->json('data.id'))->where('taggable_type', Project::class)->count();
        $this->assertEquals(3, $projectTags);
    }

    public function test_a_user_can_duplicate_his_project_with_params_even_if_it_is_not_published_or_is_public(): void
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->hasTags(3)->create([
            'author_id' => $user->id,
            'published' => false,
            'public' => false,
        ]);

        $data = [
            'name' => $this->faker()->name
        ];
        $response = $this->postJson(route('projects.fork', $project->id), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure(),
        ]);
        $response->assertJsonStructure([
            'data' => [
                'forkedFrom' => $this->structure(),
            ],
        ]);
        $this->assertDatabaseHas('projects', [
            'name' => $data['name'] . ' (forked)',
            'style_id' => $project->style_id,
            'author_id' => $user->id,
            'forked_from_id' => $project->id,
            'published' => false,
            'public' => false
        ]);
        $this->assertDatabaseCount('tags', 3);
        $projectTags = \DB::table('taggables')->where('taggable_id', $response->json('data.id'))->where('taggable_type', Project::class)->count();
        $this->assertEquals(3, $projectTags);
    }
}
