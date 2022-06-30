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
            ['name' => 'Lighting'],
            ['name' => 'Vegetation'],
            ['name' => 'Art'],
            ['name' => 'Drapery'],
            ['name' => 'Rugs'],
            ['name' => 'Decor'],
        ])->each(function ($category){
            $currentCategory = Category::query()->where('name', $category['name'])->first();
            if (is_null($currentCategory)) {
                Category::factory()->create([
                    'name' => $category['name'],
                    'parent_id' => null,
                    'active' => true,
                ]);
            }
        });
    }
}
