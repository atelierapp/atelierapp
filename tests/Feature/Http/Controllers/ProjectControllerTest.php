<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
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
        $projects = factory(Project::class, 3)->create();

        $response = $this->get(route('project.index'));
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
        $project = $this->faker->word;

        $response = $this->post(route('project.store'), [
            'project' => $project,
        ]);

        $projects = Project::query()
            ->where('project', $project)
            ->get();
        $this->assertCount(1, $projects);
        $project = $projects->first();
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $project = factory(Project::class)->create();

        $response = $this->get(route('project.show', $project));
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
        $project = factory(Project::class)->create();
        $project = $this->faker->word;

        $response = $this->put(route('project.update', $project), [
            'project' => $project,
        ]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $project = factory(Project::class)->create();

        $response = $this->delete(route('project.destroy', $project));

        $response->assertOk();

        $this->assertDeleted($project);
    }
}
