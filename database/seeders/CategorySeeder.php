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
            ['id' => 1, 'name' => ['en' => 'Bed', 'es' => 'Cama']],
            ['id' => 2, 'name' => ['en' => 'Chair', 'es' => 'Silla']],
            ['id' => 3, 'name' => ['en' => 'Coffee Table', 'es' => 'Mesa de centro']],
            ['id' => 4, 'name' => ['en' => 'Console', 'es' => 'Consola']],
            ['id' => 5, 'name' => ['en' => 'Desk', 'es' => 'Escritorio']],
            ['id' => 6, 'name' => ['en' => 'Dining Chair', 'es' => 'Silla del comedor']],
            ['id' => 7, 'name' => ['en' => 'Dining Table', 'es' => 'Comedor']],
            ['id' => 8, 'name' => ['en' => 'Dresser', 'es' => 'Vestidor']],
            ['id' => 9, 'name' => ['en' => 'Nightstand', 'es' => 'Mesita de noche']],
            ['id' => 10, 'name' => ['en' => 'Ottoman', 'es' => 'Otomano']],
            ['id' => 11, 'name' => ['en' => 'Shelf', 'es' => 'Estante']],
            ['id' => 12, 'name' => ['en' => 'Side Table', 'es' => 'Mesa auxiliar']],
            ['id' => 13, 'name' => ['en' => 'Sofa', 'es' => 'Sofá']],
            ['id' => 14, 'name' => ['en' => 'Lighting', 'es' => 'Encendiendo']],
            ['id' => 15, 'name' => ['en' => 'Vegetation', 'es' => 'Vegetación']],
            ['id' => 16, 'name' => ['en' => 'Art', 'es' => 'Arte']],
            ['id' => 17, 'name' => ['en' => 'Drapery', 'es' => 'Pañería']],
            ['id' => 18, 'name' => ['en' => 'Rugs', 'es' => 'Alfombras']],
            ['id' => 19, 'name' => ['en' => 'Decor', 'es' => 'Decoración']],
        ])->each(function ($element) {
            $category = Category::query()->where('id', $element['id'])->firstOrNew();
            $category->name = $element['name'];
            $category->active = true;
            $category->save();
        });
    }
}
