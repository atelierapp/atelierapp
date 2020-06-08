<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Style;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProjectController
 */
class ProjectControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $user = $this->createAuthenticatedUser();
        factory(Project::class)->times(30)->create(['author_id' => $user->id]);

        $response = $this->getJson(route('projects.index'));

        $response
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'store',
            \App\Http\Requests\ProjectStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $user = $this->createAuthenticatedUser();

        $data = [
            'name' => $name = $this->faker->word,
            'style_id' => factory(Style::class)->create()->id,
            'author_id' => $user->id,
        ];

        $response = $this->postJson(route('projects.store'), $data);

        $projects = Project::query()
            ->where('author_id', $user->id)
            ->get();
        $this->assertCount(1, $projects);

        $response
            ->assertCreated()
            ->assertJsonFragment([
                'name' => $name,
                'published' => true,
            ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $user = $this->createAuthenticatedUser();
        $project = factory(Project::class)->create(['author_id' => $user->id]);

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
     */
    public function update_behaves_as_expected()
    {
        $user = $this->createAuthenticatedUser();
        $project = factory(Project::class)->create(['author_id' => $user->id]);

        $data = ['name' => $newName = $this->faker->word];

        $response = $this->patchJson(route('projects.update', $project), $data);

        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $newName]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $user = $this->createAuthenticatedUser();
        $project = factory(Project::class)->create(['author_id' => $user->id]);

        $response = $this->deleteJson(route('projects.destroy', $project));

        $response->assertOk();
        $this->assertSoftDeleted($project);
    }
}
