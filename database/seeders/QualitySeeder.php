<?php

namespace Database\Seeders;

use App\Models\Quality;
use Illuminate\Database\Seeder;

class QualitySeeder extends Seeder
{
    public function run(): void
    {
        Quality::create(['name' => 'Circular economy']);
        Quality::create(['name' => 'Fair trade']);
        Quality::create(['name' => 'Part of reforestation programs']);
        Quality::create(['name' => 'Part of give back programs and causes']);
        Quality::create(['name' => 'Sustainable manufactured']);
        Quality::create(['name' => 'Sustainably sourced']);
    }
}
