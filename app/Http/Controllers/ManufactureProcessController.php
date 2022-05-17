<?php

namespace App\Http\Controllers;

use App\Enums\ManufacturerProcessEnum;

class ManufactureProcessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke()
    {
        $rows = collect(ManufacturerProcessEnum::MAP_VALUE);
        $result = [];

        $rows->each( function ($index, $value) use (&$result) {
            $result[] = [
                'id' => $index,
                'name' => $value,
            ];
        });

        return response()->json(['data' => $result], 200);
    }
}
