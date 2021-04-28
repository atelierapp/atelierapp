<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Category::factory()->create([
            'name' => 'Bed',
        ]);
        Category::factory()->create([
            'name' => 'Chair',
        ]);
        Category::factory()->create([
            'name' => 'Coffee Table',
        ]);
        Category::factory()->create([
            'name' => 'Console',
        ]);
        Category::factory()->create([
            'name' => 'Desk',
        ]);
        Category::factory()->create([
            'name' => 'Dining Chair',
        ]);
        Category::factory()->create([
            'name' => 'Dining Table',
        ]);
        Category::factory()->create([
            'name' => 'Dresser',
        ]);
        Category::factory()->create([
            'name' => 'Nightstand',
        ]);
        Category::factory()->create([
            'name' => 'Ottoman',
        ]);
        Category::factory()->create([
            'name' => 'Shelf',
        ]);
        Category::factory()->create([
            'name' => 'Side Table',
        ]);
        Category::factory()->create([
            'name' => 'Sofa',
        ]);
    }
}
