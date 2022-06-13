<?php

namespace App\Http\Controllers;

use App\Enums\ManufacturerTypeEnum;

class ManufactureTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke()
    {
        $rows = collect(ManufacturerTypeEnum::MAP_VALUE);
        $result = [];

        $rows->each( function ($index, $value) use (&$result) {
            $result[] = [
                'id' => $value,
                'name' => $index,
            ];
        });

        return response()->json(['data' => $result], 200);
    }
}
