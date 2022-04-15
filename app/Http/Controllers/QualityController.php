<?php

namespace App\Http\Controllers;

use App\Http\Requests\QualityStoreRequest;
use App\Http\Requests\QualityUpdateRequest;
use App\Http\Resources\QualityResource;
use App\Models\Quality;
use App\Models\Role;
use Bouncer;
use Illuminate\Auth\Access\AuthorizationException;

class QualityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        $qualities = Quality::all();

        return QualityResource::collection($qualities);
    }

    public function store(QualityStoreRequest $request)
    {
        $quality = Quality::create($request->validated());

        return QualityResource::make($quality);
    }

    public function update(QualityUpdateRequest $request, $quality)
    {
        $quality = Quality::findOrFail($quality);
        $quality->update($request->validated());

        return QualityResource::make($quality);
    }

    public function destroy($quality)
    {
        if (Bouncer::is(auth()->user())->notAn('admin')) {
            throw new AuthorizationException;
        }

        $quality = Quality::query()
            ->where('id', '=', $quality)
            ->withCount(['store'])
            ->firstOrFail();

        if ($quality->store_count) {
            return response()->json(['message' => 'Quality cannot delete because has associated stores']);
        }

        $quality->delete();

        return response()->json([], 204);
    }
}
