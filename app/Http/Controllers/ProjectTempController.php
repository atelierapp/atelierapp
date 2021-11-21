<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectTempController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = auth()->user()->projects()->latest()->get();

        return $this->response($projects);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'style_id' => ['required', 'exists:styles,id'],
            'settings' => ['required', 'array'],
        ]);

        $data = $request->all();
        $data['author_id'] = auth()->id();
        $project = Project::create($data);

        return $this->response($project->toArray(), Response::HTTP_CREATED);
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $request->validate([
            'settings' => ['required', 'array'],
        ]);

        $project->settings = $request->all()['settings'];
        $project->save();

        return $this->response($project->toArray(), Response::HTTP_CREATED);
    }
}
