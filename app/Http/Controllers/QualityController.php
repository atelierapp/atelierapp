<?php

namespace App\Http\Controllers;

use App\Http\Resources\QualityResource;
use App\Models\Quality;

class QualityController extends Controller
{
    public function index()
    {
        $qualities = Quality::all();

        return QualityResource::collection($qualities);
    }
}
