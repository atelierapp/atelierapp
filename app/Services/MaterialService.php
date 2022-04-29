<?php

namespace App\Services;

use App\Models\Material;

class MaterialService
{
    public function getMaterial(string $material): Material
    {
        return Material::updateOrCreate(['name' => $material]);
    }
}
