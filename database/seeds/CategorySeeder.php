<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Desks'],
            ['name' => 'Sofas'],
            ['name' => 'Furniture'],
            ['name' => 'Frames'],
        ];

        foreach ($categories as $category) {
            $category = \App\Models\Category::firstOrCreate($category);
            $category->products()->saveMany(
                factory(\App\Models\Product::class, rand(5, 20))->make()
            );
        }
    }
}
