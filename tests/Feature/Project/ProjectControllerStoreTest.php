<?php

namespace Tests\Feature\Project;

use App\Models\Project;
use App\Models\Style;
use App\Models\Tag;

class ProjectControllerStoreTest extends BaseTest
{

    public function test_a_guess_cannot_create_any_project(): void
    {
        $response = $this->postJson(route('projects.store'), []);

        $response->assertUnauthorized();
    }

    public function test_store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProjectController::class,
            'store',
            \App\Http\Requests\ProjectStoreRequest::class
        );
    }

    public function test_store_saves_without_fork(): void
    {
        $user = $this->createAuthenticatedUser();

        $data = [
            'name' => $name = $this->faker->name,
            'style_id' => Style::factory()->create()->id,
            'author_id' => $user->id,
        ];
        $response = $this->postJson(route('projects.store'), $data, $this->customHeaders());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->structure()
        ]);
        $response->assertJsonStructure([
            'data' => $this->structureAuthor(),
        ]);
        $response->assertJsonStructure([
            'data' => $this->structureStyle(),
        ]);
        $this->assertEquals($name, $response->json('data.name'));
        $this->assertEquals($user->id, $response->json('data.author_id'));
        $this->assertEquals($user->first_name, $response->json('data.author.first_name'));

        $this->assertDatabaseHas('projects', $data);
    }

    public function test_store_a_project_with_tags(): void
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

        $response = $this->postJson(route('projects.store'), $data, $this->customHeaders());

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
}
