<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        collect([
            [
                'id' => 1,
                'name' => [
                    'en' => 'Bed',
                    'es' => 'Cama',
                ],
                'image' => 'categories/bed.png',
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
                'image' => 'categories/coffee_table.png',
            ],
            [
                'id' => 4,
                'name' => [
                    'en' => 'Console',
                    'es' => 'Consola',
                ],
                'image' => 'categories/console.png',
            ],
            [
                'id' => 5,
                'name' => [
                    'en' => 'Desk',
                    'es' => 'Escritorio',
                ],
                'image' => 'categories/desk.png',
            ],
            [
                'id' => 6,
                'name' => [
                    'en' => 'Dining Chair',
                    'es' => 'Silla del comedor',
                ],
                'image' => 'categories/dinner_chair.png',
            ],
            [
                'id' => 7,
                'name' => [
                    'en' => 'Dining Table',
                    'es' => 'Comedor',
                ],
                'image' => 'categories/dinner_table.png',
            ],
            [
                'id' => 8,
                'name' => [
                    'en' => 'Dresser',
                    'es' => 'Vestidor',
                ],
                'image' => 'categories/dresser.png',
            ],
            [
                'id' => 9,
                'name' => [
                    'en' => 'Nightstand',
                    'es' => 'Mesita de noche',
                ],
                'image' => 'categories/nightstand.png',
            ],
            [
                'id' => 10,
                'name' => [
                    'en' => 'Ottoman',
                    'es' => 'Otomano',
                ],
                'image' => 'categories/ottoman.png',
            ],
            [
                'id' => 11,
                'name' => [
                    'en' => 'Shelf',
                    'es' => 'Repisas',
                ],
                'image' => 'categories/shelf.png',
            ],
            [
                'id' => 12,
                'name' => [
                    'en' => 'Side Table',
                    'es' => 'Mesa auxiliar',
                ],
                'image' => 'categories/side_table.png',
            ],
            [
                'id' => 13,
                'name' => [
                    'en' => 'Sofa',
                    'es' => 'Sofá',
                ],
                'image' => 'categories/sofa.png',
            ],
            [
                'id' => 14,
                'name' => [
                    'en' => 'Lighting',
                    'es' => 'Encendiendo',
                ],
                'image' => 'categories/lighting.png',
            ],
            [
                'id' => 15,
                'name' => [
                    'en' => 'Vegetation',
                    'es' => 'Vegetación',
                ],
                'image' => 'categories/vegetation.png',
            ],
            [
                'id' => 16,
                'name' => [
                    'en' => 'Art',
                    'es' => 'Arte',
                ],
                'image' => 'categories/art.png',
            ],
            [
                'id' => 17,
                'name' => [
                    'en' => 'Drapery',
                    'es' => 'Pañería',
                ],
                'image' => 'categories/drapery.png',
            ],
            [
                'id' => 18,
                'name' => [
                    'en' => 'Rugs',
                    'es' => 'Alfombras',
                ],
                'image' => 'categories/accesories.png',
            ],
            [
                'id' => 19,
                'name' => [
                    'en' => 'Decor',
                    'es' => 'Decoración',
                ],
                'image' => 'categories/decor.png',
            ],
            [
                'id' => 20,
                'name' => [
                    'en' => 'Others',
                    'es' => 'Otros',
                ],
                'image' => 'categories/other.png',
            ],
            [
                'id' => 21,
                'name' => [
                    'en' => 'Accesories',
                    'es' => 'Accesorios',
                ],
                'image' => 'categories/accesories.png',
            ],
            [
                'id' => 22,
                'name' => [
                    'en' => 'Plumbing fixtures',
                    'es' => 'Accesorios de plomeria',
                ],
                'image' => 'categories/plumbing_fixtures.png',
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
