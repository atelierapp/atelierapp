<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class ProjectService
{
    public function __construct(private TagService $tagService)
    {
        //
    }

    public function index(?int $userId, ?string $search)
    {
        return Project::query()
            ->with('style', 'author', 'featured_media')
            ->search($search)
            ->authUser($userId)
            ->latest()
            ->paginate();
    }

    public function store(array $params = []): Project
    {
        $params['author_id'] = auth()->id();

        $project = Project::query()->create($params);
        $this->processTags($project, Arr::get($params, 'tags', []));
        $this->loadRelations($project);
        $project->refresh();

        return $project;
    }

    private function processTags(Project &$project, array $tags): void
    {
        if (count($tags)) {
            $projectTags = [];
            foreach ($tags as $tag) {
                $projectTags[] = $this->tagService->getTag($tag['name']);
            }
            $project->tags()->saveMany($projectTags);
            $project->load('tags');
        }
    }

    private function loadRelations(Project &$project): void
    {
        $project->load('style', 'author', 'forkedFrom');
    }

    public function getBy(int|string $projectId, string $field = 'id', bool $throwable = true): Project
    {
        $query = Project::query()->where($field, $projectId);

        return $throwable
            ? $query->firstOrFail()
            : $query->firstOrNew();
    }

    public function update($project, array $params)
    {
        $project = $this->getBy($project);

        if ($project->author_id != auth()->id()) {
            throw new ModelNotFoundException();
        }

        $project->fill($params);
        $project->save();
        $this->loadRelations($project);

        return $project;
    }
}
