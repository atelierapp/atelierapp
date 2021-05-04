<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Tag;

class ProjectController extends Controller
{

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $projects = Project::with('style', 'author')->search(request('search'))->paginate();

        return ProjectResource::collection($projects);
    }

    public function store(ProjectStoreRequest $request): ProjectResource
    {
        $project = Project::create($request->validated());

        if (! empty($request->get('tags'))) {
            $tags = [];
            foreach ($request->tags as $tag) {
                $tags[] = Tag::query()->firstOrNew([
                    'name' => $tag['name']
                ]);
            }
            $project->tags()->saveMany($tags);
        }

        $project->loadMissing('style', 'author', 'forkedFrom');

        return ProjectResource::make($project);
    }

    public function show(Project $project): ProjectResource
    {
        return ProjectResource::make($project);
    }

    public function update(ProjectUpdateRequest $request, Project $project): ProjectResource
    {
        $project->update($request->validated());

        return ProjectResource::make($project);
    }

    public function destroy(Project $project): \Illuminate\Http\JsonResponse
    {
        $project->delete();

        return $this->responseNoContect();
    }

}
