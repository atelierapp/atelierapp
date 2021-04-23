<?php

namespace Database\Seeders;

use App\Models\UnitSystem;
use Illuminate\Database\Seeder;

class UnitSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        UnitSystem::factory()->count(5)->create();
    }
}
