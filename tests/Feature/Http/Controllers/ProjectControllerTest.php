<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Style;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        Project::factory()->times(5)->create(['author_id' => $user->id, 'forked_from_id' => null]);

        $response = $this->getJson(route('projects.index'), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure(
            [
                'data' => [
                    0 => [
                        'id',
                        'name',
                        'style',
                        'author',
                        'published',
                        'public',
                    ]
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
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
        $user = $this->createAuthenticatedUser();
        $params = [
            'search' => 'test-project'
        ];
        Project::factory()->times(5)->create(['author_id' => $user->id, 'forked_from_id' => null]);
        Project::factory()->create(['name' => $params['search'], 'forked_from_id' => null]);

        $response = $this->getJson(route('projects.index', $params), $this->customHeaders());

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonStructure(
            [
                'data' => [
                    0 => [
                        'id',
                        'name',
                        'style',
                        'author',
                        'published',
                        'public',
                    ]
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
                ]
            ]
        );
        $this->assertDatabaseCount('projects', 6);
    }

    /**
     * @test
     * @title Create product
     */
    public function user_can_upload_a_image_to_exists_project()
    {
        Storage::fake('s3');
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->create(['author_id' => $user->id]);

        $data = [
            'image' => UploadedFile::fake()->image('imagen.jpg'),
        ];
        $response = $this->postJson(route('projects.image', $project), $data, $this->customHeaders());

        $response->assertOk();
        $this->assertEquals(1, count(Storage::disk('s3')->allFiles('projects')));
    }

    /**
     * @test
     * @title Show project
     */
    public function show_behaves_as_expected()
    {
        $user = $this->createAuthenticatedUser();
        $project = Project::factory()->create(['author_id' => $user->id]);

        $response = $this->getJson(route('projects.show', $project), $this->customHeaders());

        $response
            ->assertOk()
            ->assertJsonStructure([
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
                    'updated_at'
                ]
            ])
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

        $data = ['name' => $this->faker->firstName];

        $response = $this->patchJson(route('projects.update', $project), $data, $this->customHeaders());

        $response
            ->assertOk()
            ->assertJsonStructure([
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
                    'updated_at'
                ]
            ])
            ->assertJsonFragment(['name' => $data['name']]);
    }

    /**
     * @test
     * @title A user can't update someone else's projects
     */
    public function a_user_cannot_update_someone_else_projects()
    {
        $this->createAuthenticatedUser();
        $project = Project::factory()->create();

        $data = ['name' => $this->faker->paragraph];

        $response = $this->patchJson(route('projects.update', $project), $data, $this->customHeaders());

        $response->assertNotFound();
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

        $response = $this->deleteJson(route('projects.destroy', $project),[], $this->customHeaders());

        $response->assertNoContent();
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

        $response = $this->deleteJson(route('projects.destroy', $project),[], $this->customHeaders());

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
    }
}
