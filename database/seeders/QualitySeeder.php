<?php

namespace Database\Seeders;

use App\Models\Quality;
use Illuminate\Database\Seeder;

class QualitySeeder extends Seeder
{
    public function run(): void
    {
        Quality::query()->updateOrCreate(['name' => 'Circular economy']);
        Quality::query()->updateOrCreate(['name' => 'Fair trade']);
        Quality::query()->updateOrCreate(['name' => 'Part of reforestation programs']);
        Quality::query()->updateOrCreate(['name' => 'Part of give back programs and causes']);
        Quality::query()->updateOrCreate(['name' => 'Sustainable manufactured']);
        Quality::query()->updateOrCreate(['name' => 'Sustainably sourced']);
    }
}
