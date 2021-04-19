<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database Seeders.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect([
            ['name' => 'Desks'],
            ['name' => 'Sofas'],
            ['name' => 'Furniture'],
            ['name' => 'Frames'],
        ]);

        $categories->each(function ($category) {
            Category::factory()->times(rand(5, 20))->create(['name' => $category['name']]);
        });
    }
}
