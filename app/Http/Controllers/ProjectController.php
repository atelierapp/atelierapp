<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Tag;
use App\Traits\Controllers\StorageS3ImageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    use StorageS3ImageTrait;

    public function index(): AnonymousResourceCollection
    {
        $projects = Project::with('style', 'author', 'featured_media')->search(request('search'))->paginate();

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
