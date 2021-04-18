<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectDeleteRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\ProjectCollection;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = \Auth::user()->projects()->paginate($request->get('paginate', 10));

        return new ProjectCollection($projects);
    }

    public function store(ProjectStoreRequest $request)
    {
        $project = ($user = Auth::user())->projects()->create($request->validated());

        return $this->response(new ProjectResource($project->fresh()), '', Response::HTTP_CREATED);
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $project->update($request->validated());

        return new ProjectResource($project->fresh());
    }

    /**
     * @param ProjectDeleteRequest $request
     * @param Project $project
     * @return Response
     * @throws Exception
     */
    public function destroy(ProjectDeleteRequest $request, Project $project)
    {
        $project->delete();

        return response()->noContent(200);
    }
}
