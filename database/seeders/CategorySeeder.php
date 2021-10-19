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
        collect([
            ['name' => 'Bed'],
            ['name' => 'Chair'],
            ['name' => 'Coffee Table'],
            ['name' => 'Console'],
            ['name' => 'Desk'],
            ['name' => 'Dining Chair'],
            ['name' => 'Dining Table'],
            ['name' => 'Dresser'],
            ['name' => 'Nightstand'],
            ['name' => 'Ottoman'],
            ['name' => 'Shelf'],
            ['name' => 'Side Table'],
            ['name' => 'Sofa'],
        ])->each(function ($category){
            Category::factory()->create([
                'name' => $category['name'],
                'parent_id' => null,
                'active' => true,
            ]);
        });
    }
}
