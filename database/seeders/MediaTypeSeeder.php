<?php

namespace Database\Seeders;

use App\Models\MediaType;
use Illuminate\Database\Seeder;

class MediaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        MediaType::create([
            'name' => MediaType::IMAGE,
        ]);
        MediaType::create([
            'name' => MediaType::VIDEO,
        ]);
    }
}
