<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProjectController extends Controller
{

    public function index(): ProjectCollection
    {
        $projects = Project::all();

        return new ProjectCollection($projects);
    }

    public function store(ProjectStoreRequest $request): ProjectResource
    {
        $project = Project::create($request->validated());

        return new ProjectResource($project);
    }

    public function show(Project $project): ProjectResource
    {
        return new ProjectResource($project);
    }

    public function update(ProjectUpdateRequest $request, Project $project): ProjectResource
    {
        $project->update($request->validated());

        return new ProjectResource($project);
    }

    public function destroy(Project $project): \Illuminate\Http\JsonResponse
    {
        $project->delete();

        return response()->json([], 200);
    }
}
