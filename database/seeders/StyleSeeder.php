<?php

namespace Database\Seeders;

use App\Models\Style;
use Illuminate\Database\Seeder;

class StyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Style::create([
            'name' => $name = 'Mediterranean',
            'code' => \Str::of($name)->lower()->kebab(),
        ]);
        Style::create([
            'name' => $name = 'Rustic',
            'code' => \Str::of($name)->lower()->kebab(),
        ]);
        Style::create([
            'name' => $name = 'Glam',
            'code' => \Str::of($name)->lower()->kebab(),
        ]);
        Style::create([
            'name' => $name = 'Mid Century Modern ',
            'code' => \Str::of($name)->lower()->kebab(),
        ]);
        Style::create([
            'name' => $name = 'Contemporary',
            'code' => \Str::of($name)->lower()->kebab(),
        ]);
        Style::create([
            'name' => $name = 'Shabby Chic',
            'code' => \Str::of($name)->lower()->kebab(),
        ]);
        Style::create([
            'name' => $name = 'Eclectic',
            'code' => \Str::of($name)->lower()->kebab(),
        ]);
        Style::create([
            'name' => $name = 'Traditional',
            'code' => \Str::of($name)->lower()->kebab(),
        ]);
    }
}
