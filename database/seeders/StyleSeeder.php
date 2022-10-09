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
            ['name' => 'Mediterranean'],
            ['name' => 'Rustic'],
            ['name' => 'Glam'],
            ['name' => 'Mid Century Modern'],
            ['name' => 'Contemporary'],
            ['name' => 'Shabby Chic'],
            ['name' => 'Eclectic'],
            ['name' => 'Traditional'],
        ])->each(fn ($style) => Style::updateOrCreate([
               'code' => Str::of($style['name'])->lower()->kebab()
            ], [
                'name' => $style['name']
            ])
        );
    }
}
