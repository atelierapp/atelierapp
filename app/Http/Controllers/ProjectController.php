<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectDetailResource;
use App\Http\Resources\ProjectIndexResource;
use App\Models\Project;
use App\Models\Tag;

class ProjectController extends Controller
{

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $projects = Project::with('style', 'author')->search(request('search'))->paginate();

        return ProjectIndexResource::collection($projects);
    }

    public function store(ProjectStoreRequest $request): ProjectDetailResource
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

        return ProjectDetailResource::make($project);
    }

    public function show(Project $project): ProjectDetailResource
    {
        return ProjectDetailResource::make($project);
    }

    public function update(ProjectUpdateRequest $request, Project $project): ProjectDetailResource
    {
        $project->update($request->validated());

        return ProjectDetailResource::make($project);
    }

    public function destroy(Project $project): \Illuminate\Http\JsonResponse
    {
        $project->delete();

        return $this->responseNoContect();
    }

}
