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
                'score' => 2,
            ],
            [
                'id' => 2,
                'name' => [
                    'en' => 'Fair trade',
                    'es' => 'Comercio justo',
                ],
                'score' => 2,
            ],
            [
                'id' => 3,
                'name' => [
                    'en' => 'Part of reforestation programs',
                    'es' => 'Parte de los programas de reforestación',
                ],
                'score' => 1,
            ],
            [
                'id' => 4,
                'name' => [
                    'en' => 'Part of give back programs and causes',
                    'es' => 'Parte de los programas y causas de devolución',
                ],
                'score' => 1,
            ],
            [
                'id' => 5,
                'name' => [
                    'en' => 'Sustainable manufactured',
                    'es' => 'Fabricación sostenible',
                ],
                'score' => 3,
            ],
            [
                'id' => 6,
                'name' => [
                    'en' => 'Sustainably sourced',
                    'es' => 'Fuente sostenible',
                ],
                'score' => 3,
            ],
            [
                'id' => 7,
                'name' => [
                    'en' => 'Sustainably Transported',
                    'es' => 'Transportado de manera sostenible',
                ],
                'score' => 1,
            ],
        ])->each(fn ($style) => $this->processModel($style));
    }

    private function processModel($style)
    {
        $quality = Quality::where('id', $style['id'])->firstOrNew();
        $quality->id = $style['id'];
        $quality->name = $style['name'];
        $quality->score = $style['score'];
        $quality->save();
    }
}
