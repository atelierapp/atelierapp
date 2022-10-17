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
            [
                'id' => 1,
                'name' => [
                    'en' => 'Bed',
                    'es' => 'Cama',
                ],
                'image' => 'categories/cat-bed.png',
            ],
            [
                'id' => 2,
                'name' => [
                    'en' => 'Chair',
                    'es' => 'Silla',
                ],
                'image' => 'categories/cat-chair.png',
            ],
            [
                'id' => 3,
                'name' => [
                    'en' => 'Coffee Table',
                    'es' => 'Mesa de centro',
                ],
                'image' => 'categories/cat-cofee-table.png',
            ],
            [
                'id' => 4,
                'name' => [
                    'en' => 'Console',
                    'es' => 'Consola',
                ],
                'image' => null,
            ],
            [
                'id' => 5,
                'name' => [
                    'en' => 'Desk',
                    'es' => 'Escritorio',
                ],
                'image' => 'categories/cat-desk.png',
            ],
            [
                'id' => 6,
                'name' => [
                    'en' => 'Dining Chair',
                    'es' => 'Silla del comedor',
                ],
                'image' => 'categories/cat-dining-chair.png',
            ],
            [
                'id' => 7,
                'name' => [
                    'en' => 'Dining Table',
                    'es' => 'Comedor',
                ],
                'image' => 'categories/cat-dningin-table.png',
            ],
            [
                'id' => 8,
                'name' => [
                    'en' => 'Dresser',
                    'es' => 'Vestidor',
                ],
                'image' => null,
            ],
            [
                'id' => 9,
                'name' => [
                    'en' => 'Nightstand',
                    'es' => 'Mesita de noche',
                ],
                'image' => 'categories/cat-nightstand.png',
            ],
            [
                'id' => 10,
                'name' => [
                    'en' => 'Ottoman',
                    'es' => 'Otomano',
                ],
                'image' => 'categories/cat-ottoman.png',
            ],
            [
                'id' => 11,
                'name' => [
                    'en' => 'Shelf',
                    'es' => 'Estante',
                ],
                'image' => 'categories/cat-shelf.png',
            ],
            [
                'id' => 12,
                'name' => [
                    'en' => 'Side Table',
                    'es' => 'Mesa auxiliar',
                ],
                'image' => null,
            ],
            [
                'id' => 13,
                'name' => [
                    'en' => 'Sofa',
                    'es' => 'Sofá',
                ],
                'image' => 'categories/cat-sofa.png',
            ],
            [
                'id' => 14,
                'name' => [
                    'en' => 'Lighting',
                    'es' => 'Encendiendo',
                ],
                'image' => 'categories/cat-lighting.png',
            ],
            [
                'id' => 15,
                'name' => [
                    'en' => 'Vegetation',
                    'es' => 'Vegetación',
                ],
                'image' => 'categories/cat-vegetation.png',
            ],
            [
                'id' => 16,
                'name' => [
                    'en' => 'Art',
                    'es' => 'Arte',
                ],
                'image' => 'categories/cat-art.png',
            ],
            [
                'id' => 17,
                'name' => [
                    'en' => 'Drapery',
                    'es' => 'Pañería',
                ],
                'image' => 'null',
            ],
            [
                'id' => 18,
                'name' => [
                    'en' => 'Rugs',
                    'es' => 'Alfombras',
                ],
                'image' => 'null',
            ],
            [
                'id' => 19,
                'name' => [
                    'en' => 'Decor',
                    'es' => 'Decoración',
                ],
                'image' => 'null',
            ],
            [
                'id' => 20,
                'name' => [
                    'en' => 'Others',
                    'es' => 'Otros',
                ],
                'image' => 'null',
            ],
            [
                'id' => 21,
                'name' => [
                    'en' => 'Accesories',
                    'es' => 'Accesorios',
                ],
                'image' => 'null',
            ],
            [
                'id' => 22,
                'name' => [
                    'en' => 'Plumbing fixtures',
                    'es' => 'Accesorios de plomeria',
                ],
                'image' => 'categories/cat-plumbing-fixtures.png',
            ],
        ])->each(function ($element) {
            $category = Category::query()->where('id', $element['id'])->firstOrNew();
            $category->id = $element['id'];
            $category->name = $element['name'];
            $category->image = $element['image'];
            $category->active = true;
            $category->save();
        });
    }
}
