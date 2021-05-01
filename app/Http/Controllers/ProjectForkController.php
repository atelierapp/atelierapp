<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectForkRequest;
use App\Http\Resources\ProjectDetailResource;
use App\Models\Project;

class ProjectForkController extends Controller
{

    public function __invoke(ProjectForkRequest $request, Project $project): ProjectDetailResource
    {
        $data = [
            'name' => $request->get('name', $project->name . ' (forked)'),
            'style_id' => $request->get('style_id', $project->style_id),
            'author_id' => auth()->id(),
            'forked_from_id' => $project->id,
            'published' => false,
            'public' => false
        ];

        $forkedProject = Project::create($data);
        $forkedProject->load('style', 'author', 'forkedFrom');

        return ProjectDetailResource::make($forkedProject);
    }

}
