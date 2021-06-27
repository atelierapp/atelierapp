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
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Chair',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Coffee Table',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Console',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Desk',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Dining Chair',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Dining Table',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Dresser',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Nightstand',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Ottoman',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Shelf',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Side Table',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Sofa',
            'parent_id' => null,
            'active' => true,
        ]);
        Category::factory()->create([
            'name' => 'Tiles',
            'parent_id' => null,
            'active' => true,
        ]);
    }
}
