<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Requests\Process\ProductProjectStoreRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;

class ProductProjectController extends Controller
{
    public function __construct(
        private ProjectService $projectService
    ) {
    }

    public function store(ProductProjectStoreRequest $request, $project)
    {
        $project = $this->projectService->getByAuth($project);
        $this->projectService->attachProduct($project, $request->validated());
        $this->projectService->loadRelations($project);

        return ProjectResource::make($project)->response()->setStatusCode(201);
    }
}
