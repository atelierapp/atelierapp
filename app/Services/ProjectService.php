<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Arr;

class ProjectService
{
    public function __construct(private TagService $tagService)
    {
        //
    }

    public function store(array $params = []): Project
    {
        $params['author_id'] = auth()->id();

        $project = Project::query()->create($params);
        $this->processTags($project, Arr::get($params, 'tags', []));
        $project->load('style', 'author', 'forkedFrom');
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
}
