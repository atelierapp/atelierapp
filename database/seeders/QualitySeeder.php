<?php

namespace Database\Seeders;

use App\Models\Quality;
use Illuminate\Database\Seeder;

class QualitySeeder extends Seeder
{
    public function run(): void
    {
        collect([
            ['name' => 'Circular economy'],
            ['name' => 'Fair trade'],
            ['name' => 'Part of reforestation programs'],
            ['name' => 'Part of give back programs and causes'],
            ['name' => 'Sustainable manufactured'],
            ['name' => 'Sustainably sourced'],
        ])->each(fn ($style) => Quality::updateOrCreate(['name' => $style['name']]));
    }
}
