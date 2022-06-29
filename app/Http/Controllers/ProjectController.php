<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Tag;
use App\Services\ProjectService;
use App\Traits\Controllers\StorageS3ImageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    use StorageS3ImageTrait;

    public function __construct(private ProjectService $projectService)
    {
        //
    }

    public function index(): AnonymousResourceCollection
    {
        $projects = Project::with('style', 'author', 'featured_media')
            ->search(request('search'))
            ->paginate();

        return ProjectResource::collection($projects);
    }

    public function store(ProjectStoreRequest $request): ProjectResource
    {
        $project = $this->projectService->store($request->validated());

        return ProjectResource::make($project);
    }

    public function show(Project $project): ProjectResource
    {
        return ProjectResource::make($project);
    }

    public function update(ProjectUpdateRequest $request, $project): ProjectResource
    {
        $project = $this->projectService->update($project, $request->validated());

        return ProjectResource::make($project);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return $this->responseNoContent();
    }

    public function image(ImageRequest $request, Project $project): ProjectResource
    {
        $this->deleteImageFromBucket($project->featured_media->path);
        $project = $this->storageImageInBucket('projects', $request->file('image'), $project, true);

        return ProjectResource::make($project);
    }
}
