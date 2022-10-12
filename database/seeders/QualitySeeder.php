<?php

namespace Database\Seeders;

use App\Models\Quality;
use Illuminate\Database\Seeder;

class QualitySeeder extends Seeder
{
    public function run(): void
    {
        collect([
            [
                'id' => 1,
                'name' => [
                    'en' => 'Circular economy',
                    'es' => 'Economía circular',
                ],
            ],
            [
                'id' => 2,
                'name' => [
                    'en' => 'Fair trade',
                    'es' => 'Comercio justo',
                ],
            ],
            [
                'id' => 3,
                'name' => [
                    'en' => 'Part of reforestation programs',
                    'es' => 'Parte de los programas de reforestación',
                ],
            ],
            [
                'id' => 4,
                'name' => [
                    'en' => 'Part of give back programs and causes',
                    'es' => 'Parte de los programas y causas de devolución',
                ],
            ],
            [
                'id' => 5,
                'name' => [
                    'en' => 'Sustainable manufactured',
                    'es' => 'Fabricación sostenible',
                ],
            ],
            [
                'id' => 6,
                'name' => [
                    'en' => 'Sustainably sourced',
                    'es' => 'Fuente sostenible',
                ],
            ],
        ])->each(fn ($style) => $this->processModel($style));
    }

    private function processModel($style)
    {
        $quality = Quality::where('id', $style['id'])->firstOrNew();
        $quality->name = $style['name'];
        $quality->save();
    }
}
