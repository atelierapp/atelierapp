<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectForkRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;

class ProjectForkController extends Controller
{
    public function __construct(private ProjectService $projectService)
    {
        //
    }

    public function __invoke(ProjectForkRequest $request, $project): ProjectResource
    {
        $forkedProject = $this->projectService->fork($project, $request->validated());

        return ProjectResource::make($forkedProject);
    }
}
