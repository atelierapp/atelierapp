<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class ProjectService
{
    public function __construct(
        private TagService $tagService,
        private MediaService $mediaService
    ) {
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

    public function fork(int|string $project, array $params): Project
    {
        $project = $this->getBy($project);

        if (!$this->validateIsForkeable($project)) {
            throw new AtelierException('You do not own this project', 403);
        }

        $data = [
            'name' => Arr::get($params, 'name', $project->name) . ' (forked)',
            'style_id' => Arr::get($params, 'style_id', $project->style_id),
            'author_id' => auth()->id(),
            'forked_from_id' => $project->id,
            'published' => false,
            'public' => false,
            'settings' => $project->settings,
        ];
        $forkedProject = Project::create($data);
        $this->processTags($forkedProject, $project->tags()->select('name')->get()->toArray());
        $this->loadRelations($forkedProject);
        $this->mediaService->model($forkedProject)->path('projects');
        $project->load('medias')->medias->each(fn ($media) => $this->mediaService->duplicate($media));

        return $forkedProject;
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

    private function validateIsForkeable(Project $project): bool
    {
        if ($project->author_id == auth()->id()) {
            return true;
        }

        if ($project->published && $project->public) {
            return true;
        }

        return false;
    }
}
