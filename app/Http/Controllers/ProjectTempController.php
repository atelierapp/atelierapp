<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectTempController extends Controller
{
    public function store(Request $request)
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
    public function index(Request $request)
    {
        $projects = auth()->user()->projects()->latest()->get();

        return $this->response($projects);
    }
}