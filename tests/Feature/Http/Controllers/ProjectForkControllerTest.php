<?php

namespace Http\Controllers;

use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

class ProjectForkControllerTest extends TestCase
{

    use AdditionalAssertions;
    use WithFaker;

    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectForkController::class,
            '__invoke',
            \App\Http\Requests\ProjectForkRequest::class
        );
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
                    'style',
                    'author_id',
                    'author',
                    'published',
                    'public',
                    'created_at',
                    'updated_at',
                    'forkedFrom' => [
                        'id',
                        'name',
                        'style_id',
                        'style',
                        'author_id',
                        'author',
                        'published',
                        'public',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]
        );
        $this->assertDatabaseHas('projects', [
            'name' => $project->name . ' (forked)',
            'style_id' => $project->style_id,
            'author_id' => $user->id,
            'forked_from_id' => $project->id,
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
                    'style',
                    'author_id',
                    'author',
                    'published',
                    'public',
                    'created_at',
                    'updated_at',
                    'forkedFrom' => [
                        'id',
                        'name',
                        'style_id',
                        'style',
                        'author_id',
                        'author',
                        'published',
                        'public',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]
        );
        $this->assertDatabaseHas('projects', [
            'name' => $data['name'],
            'style_id' => $project->style_id,
            'author_id' => $user->id,
            'forked_from_id' => $project->id,
            'published' => false,
            'public' => false
        ]);
    }

}
