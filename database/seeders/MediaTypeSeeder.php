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
        MediaType::updateOrCreate([
            'name' => MediaType::IMAGE,
        ]);
        MediaType::updateOrCreate([
            'name' => MediaType::VIDEO,
        ]);
    }
}
