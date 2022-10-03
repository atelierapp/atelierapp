<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProfileProjectController extends Controller
{
    public function __invoke()
    {
        $projects = Project::whereAuthorId(auth()->id())
            ->with('style')
            ->get();

        return ProjectResource::collection($projects);
    }
}
