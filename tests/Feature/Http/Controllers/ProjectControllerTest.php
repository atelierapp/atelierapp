<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Style;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @title Projects
 * @see \App\Http\Controllers\ProjectController
 */
class ProjectControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     * @title List projects
     */
    public function index_behaves_as_expected()
    {
        $user = $this->createAuthenticatedUser();
        Project::factory()->times(5)->create(['author_id' => $user->id, 'forked_from' => null]);

        $response = $this->getJson(route('projects.index'));

        $response
            ->assertOk()
            ->assertJsonCount(5, 'data');
        $this->assertDatabaseCount('projects', 5);

        $this->markTestIncomplete('The list should be paginated.');
    }

    /**
     * @test
     * @title List projects with filters
     */
    public function index_accepts_filters()
    {
        $this->markTestIncomplete('The list should be able to accept filters.');
    }

    /**
     * @test
     * @exc
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'store',
            \App\Http\Requests\ProjectStoreRequest::class
        );
    }

    /**
     * @test
     * @title Create project
     */
    public function store_saves()
    {
        $user = $this->createAuthenticatedUser();

        $data = [
            'name' => $name = $this->faker->name,
            'style_id' => Style::factory()->create()->id,
            'author_id' => $user->id,
        ];

        $response = $this->postJson(route('projects.store'), $data);

        $response
            ->assertCreated()
            ->assertJsonFragment(
                [
                    'name' => $name,
                    'author_id' => $user->id,
                ]
            );

        $this->assertDatabaseHas('projects', $data);
    }

    /**
     * @test
     * @title Show project
     */
    public function show_behaves_as_expected()
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->create(['author_id' => $user->id]);

        $response = $this->getJson(route('projects.show', $project));

        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $project->name]);
    }

    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'update',
            \App\Http\Requests\ProjectUpdateRequest::class
        );
    }

    /**
     * @test
     * @title Update project
     */
    public function update_behaves_as_expected()
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->create(['author_id' => $user->id]);

        $data = ['name' => $newName = $this->faker->word];

        $response = $this->patchJson(route('projects.update', $project), $data);

        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $newName]);
    }

    /**
     * @test
     * @title A user can't update someone else's projects
     */
    public function a_user_cannot_update_someone_else_projects()
    {
        $this->createAuthenticatedUser();
        $project = Project::factory()->create();

        $data = ['name' => $this->faker->word];

        $response = $this->patchJson(route('projects.update', $project), $data);

        $response->assertForbidden();
    }

    /**
     * @test
     * @title Delete project
     * @description A project can be deleted by its owner
     */
    public function destroy_deletes_and_responds_with()
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->create(['author_id' => $user->id]);

        $response = $this->deleteJson(route('projects.destroy', $project));

        $response->assertOk();
        $this->assertSoftDeleted($project);
    }

    /**
     * @test
     * @title A user can't delete someone else's projects
     */
    public function a_user_cannot_delete_someone_else_projects()
    {
        $this->createAuthenticatedUser();
        $project = Project::factory()->create();
        $project->delete();

        $response = $this->deleteJson(route('projects.destroy', $project));

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * @title A user can fork someone else project
     * @description A user can fork someone else's project to edit it in their own way.
     */
    public function a_user_can_fork_someone_else_project(): void
    {
        $this->markTestIncomplete();
    }
}
