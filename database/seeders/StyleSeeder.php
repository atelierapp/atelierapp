<?php

namespace Database\Seeders;

use App\Models\Style;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StyleSeeder extends Seeder
{
    public function run(): void
    {
        collect([
            ['id' => 1, 'name' => ['en' => 'Mediterranean', 'es' => 'Mediterráneo']],
            ['id' => 2, 'name' => ['en' => 'Rustic', 'es' => 'Rústico']],
            ['id' => 3, 'name' => ['en' => 'Glam', 'es' => 'glamour']],
            ['id' => 4, 'name' => ['en' => 'Mid Century Modern', 'es' => 'mediados de siglo moderno']],
            ['id' => 5, 'name' => ['en' => 'Contemporary', 'es' => 'Contemporáneo']],
            ['id' => 6, 'name' => ['en' => 'Shabby Chic', 'es' => 'Chic desgastado']],
            ['id' => 7, 'name' => ['en' => 'Eclectic', 'es' => 'Ecléctico']],
            ['id' => 8, 'name' => ['en' => 'Traditional', 'es' => 'Tradicional']],
        ])->each(function ($element) {
            $style = Style::where('id', $element['id'])->firstOrNew();
            $style->name = $element['name'];
            $style->code = Str::of($element['name']['en'])->lower()->kebab();
            $style->save();
        });
    }
}
