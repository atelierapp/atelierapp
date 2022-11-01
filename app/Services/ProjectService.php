<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\ProductProject;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class ProjectService
{
    public function __construct(
        private TagService $tagService,
        private MediaService $mediaService,
        private VariationService $variationService
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

    public function getBy(int|string $projectId, string $field = 'id', bool $throwable = true): Project
    {
        $query = Project::query()->where($field, $projectId);

        return $throwable
            ? $query->firstOrFail()
            : $query->firstOrNew();
    }

    public function getByAuth(int|string $projectId, string $field = 'id', bool $throwable = true): Project
    {
        $query = Project::authUser()->where($field, $projectId);

        return $throwable
            ? $query->firstOrFail()
            : $query->firstOrNew();
    }

    public function update(int|string $project, array $params): Project
    {
        $project = $this->getByAuth($project);
        $project->fill($params);
        $project->save();
        $this->loadRelations($project);

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

    public function loadRelations(Project &$project): void
    {
        $project->load('style', 'author', 'forkedFrom', 'products.variation', 'products.product');
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

    public function attachProduct(Project $project, array $params): ProductProject
    {
        $variation = $this->variationService->getBy($params['variation_id']);

        return ProductProject::updateOrCreate([
            'project_id' => $project->id,
            'variation_id' => $variation->id,
            'product_id' => $variation->product_id,
        ], [
            'quantity' => $params['quantity'],
        ]);
    }

    public function updateProduct(Project $project, int|string $variation, array $params): ProductProject
    {
        $params['variation_id'] = $variation;

        return $this->attachProduct($project, $params);
    }

    public function deleteProduct(Project $project, $variation): void
    {
        ProductProject::where('project_id', '=', $project->id)
            ->where('variation_id', '=', $variation)
            ->delete();
    }
}
