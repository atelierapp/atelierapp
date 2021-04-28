<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Style;
use App\Models\Tag;
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

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure(
            [
                'data' => [
                    0 => [
                        'id',
                        'name',
                        'style_id',
                        'author_id',
                        'forked_from',
                        'published',
                        'public'
                    ]
                ],
                'meta' => [
                    'links',
                    'current_page',
                    'from'
                ]
            ]
        );
        $this->assertDatabaseCount('projects', 5);
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
     * @title Create product
     */
    public function store_a_project_with_tags(): void
    {
        $user = $this->createAuthenticatedUser();
        $tag = Tag::factory()->create();
        $data = [
            'name' => $name = $this->faker->name,
            'style_id' => Style::factory()->create()->id,
            'author_id' => $user->id,
            'tags' => [
                ['name' => $tag->name],
                ['name' => $this->faker->text(30)],
            ]
        ];

        $response = $this->postJson(route('projects.store'), $data);

        $response->assertCreated();
        $response->assertJsonFragment([
            'name' => $name,
            'author_id' => $user->id,
        ]);
        $this->assertDatabaseHas(
            'taggables',
            [
                'taggable_type' => Project::class,
                'tag_id' => $tag->id
            ]
        );

        $data = collect($data)->except(['tags'])->toArray();
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
    public function a_user_can_fork_someone_else_project_that_is_public_and_published_without_params(): void
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->hasTags(rand(1, 3))->create(
            [
                'published' => true,
                'public' => true
            ]
        );

        $response = $this->postJson(route('projects.fork', $project->id));

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'style_id',
                    'author_id',
                    'forked_from',
                    'published',
                    'public',
                ]
            ]
        );
        $this->assertDatabaseHas('projects', [
            'name' => $project->name. ' (forked)',
            'style_id' => $project->style_id,
            'author_id' => $user->id,
            'forked_from' => $project->id,
            'published' => false,
            'public' => false
        ]);
    }

    /**
     * @test
     * @title A user can fork someone else project
     * @description A user can fork someone else's project to edit it in their own way.
     */
    public function a_user_can_fork_someone_else_project_that_is_public_and_published_with_name_param(): void
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->hasTags(rand(1, 3))->create(
            [
                'published' => true,
                'public' => true
            ]
        );
        $data = [
            'name' => $this->faker()->name
        ];

        $response = $this->postJson(route('projects.fork', $project->id), $data);

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'style_id',
                    'author_id',
                    'forked_from',
                    'published',
                    'public',
                ]
            ]
        );
        $this->assertDatabaseHas('projects', [
            'name' => $data['name'],
            'style_id' => $project->style_id,
            'author_id' => $user->id,
            'forked_from' => $project->id,
            'published' => false,
            'public' => false
        ]);
    }

}
