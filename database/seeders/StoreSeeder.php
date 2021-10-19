<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Store::factory()->create([
            'name' => 'Burke Decor',
            'active' => true,
        ]);
        Store::factory()->create([
            'name' => 'Furbish Studio',
            'active' => true,
        ]);
        Store::factory()->create([
            'name' => 'Blue Sky Environments Interior Decor',
            'active' => true,
        ]);
        Store::factory()->create([
            'name' => 'Modshop',
            'active' => true,
        ]);
        Store::factory()->create([
            'name' => 'Sofamania',
            'active' => true,
        ]);
        Store::factory()->create([
            'name' => 'Winnoby',
            'active' => true,
        ]);
        Store::factory()->create([
            'name' => 'Eternity Modern',
            'active' => true,
        ]);
        Store::factory()->create([
            'name' => 'Boulevard Eight',
            'active' => true,
        ]);
    }
}
