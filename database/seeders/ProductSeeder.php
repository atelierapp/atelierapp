<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
//        Product::factory()->hasMedias(rand(1, 2))->count(5)->create();

        // Creating products
        Product::create([
            'sku' => 'BD0001',
            'title' => 'Carmel Sideboard',
            'style_id' => 2,
            'price' => 139500,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 72,
                    'depth' => 18,
                    'height' => 31,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0002',
            'title' => 'Ace Chair',
            'style_id' => 2,
            'price' => 95000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 30,
                    'depth' => 37.5,
                    'height' => 34,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0003',
            'title' => 'Ripley Dining',
            'style_id' => 4,
            'price' => 33700,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 21,
                    'depth' => 20,
                    'height' => 31,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0004',
            'title' => 'Matthes Console',
            'style_id' => 2,
            'price' => 81000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 78.75,
                    'depth' => 15,
                    'height' => 30.75,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0005',
            'title' => 'Windsor Chair',
            'style_id' => 4,
            'price' => 31000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 18.25,
                    'depth' => 21,
                    'height' => 32.5,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0006',
            'title' => 'Tinsley Coffee Table',
            'style_id' => 2,
            'price' => 76000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 40,
                    'depth' => 40,
                    'height' => 16.25,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0007',
            'title' => 'Belmont Metal Cabinet',
            'style_id' => 8,
            'price' => 179500,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 39.5,
                    'depth' => 16.5,
                    'height' => 92.5,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0008',
            'title' => 'Sirius Adjustable Accent Table',
            'style_id' => 4,
            'price' => 23000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 10,
                    'depth' => 10,
                    'height' => 20,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0009',
            'title' => 'Goat Fur Covered Wood Bench',
            'style_id' => 2,
            'price' => 38500,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 35.5,
                    'depth' => 11.75,
                    'height' => 17.75,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0010',
            'title' => 'Hudson Coffee Table',
            'style_id' => 2,
            'price' => 173700,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 40,
                    'depth' => 40,
                    'height' => 15,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0011',
            'title' => 'Camila Metal Cabinet',
            'style_id' => 8,
            'price' => 165000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 48,
                    'depth' => 17,
                    'height' => 78,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0012',
            'title' => 'Oxford Coffee Table',
            'style_id' => 4,
            'price' => 169500,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 63,
                    'depth' => 35.5,
                    'height' => 16.25,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0013',
            'title' => 'Metal Chair w/ Wood Seat & Cotton Back Cushion',
            'style_id' => 2,
            'price' => 18400,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 22.75,
                    'depth' => 25,
                    'height' => 31.5,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0014',
            'title' => 'Maxx Swivel Chair',
            'style_id' => 8,
            'price' => 194800,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 33.5,
                    'depth' => 33.75,
                    'height' => 26,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0015',
            'title' => 'Clermont Chair',
            'style_id' => 4,
            'price' => 73200,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 30.75,
                    'depth' => 33.75,
                    'height' => 35,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0016',
            'title' => 'Dylan Sofa',
            'style_id' => 4,
            'price' => 162000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 89.75,
                    'depth' => 34.75,
                    'height' => 25.25,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0017',
            'title' => 'Habitat Sofa',
            'style_id' => 2,
            'price' => 230000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 96,
                    'depth' => 40,
                    'height' => 30,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BD0018',
            'title' => 'Emery Sofa',
            'style_id' => 4,
            'price' => 275000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 84,
                    'depth' => 36,
                    'height' => 31.5,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BSE0001',
            'title' => 'Artichoke Queen Bed',
            'style_id' => 7,
            'price' => 257500,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 66,
                    'depth' => 86.5,
                    'height' => 64.5,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BSE0002',
            'title' => 'Savannah Queen 4 Poster with Caning',
            'style_id' => 8,
            'price' => 225540,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 64.2,
                    'depth' => 88.2,
                    'height' => 78.7,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BSE0003',
            'title' => 'Empire Queen',
            'style_id' => 8,
            'price' => 212100,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 69,
                    'depth' => 91,
                    'height' => 65,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BSE0004',
            'title' => 'Azzalene Dresser',
            'style_id' => 8,
            'price' => 295000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 76,
                    'depth' => 20,
                    'height' => 36,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BSE0005',
            'title' => 'Ciborium 3 Drawers',
            'style_id' => 8,
            'price' => 190000,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 51,
                    'depth' => 20,
                    'height' => 36,
                ]
            ]
        ]);
        Product::create([
            'sku' => 'BSE0006',
            'title' => 'Bill 3-Drawer Chest',
            'style_id' => 8,
            'price' => 192500,
            'quantity' => random_int(5, 50),
            'properties' => [
                'dimensions' => [
                    'width' => 49.5,
                    'depth' => 33,
                    'height' => 19,
                ]
            ]
        ]);

        // Creating product images
        Product::all()->each(function (Product $product) {
            $views = [
                'front' => '-F',
                'side' => '-S',
                'perspective' => '-P',
            ];

            foreach ($views as $view => $suffix) {
                $product->medias()->create([
                    'url' => Str::of($product->sku)
                        ->prepend('https://atelier-staging-bucket.s3.amazonaws.com/products/')
                        ->append($suffix),
                    'featured' => $view === 'front',
                    'orientation' => $view,
                    'type_id' => 1,
                ]);
            }
        });

        collect([
            1 => [19, 20, 21],
            2 => [2, 14, 15],
            3 => [6, 10],
            4 => [1, 4],
            6 => [3, 5, 13],
            8 => [22, 23, 24],
            10 => [9, 12],
            11 => [7, 11],
            12 => [8],
            13 => [16, 17, 18],
        ])->each(function ($ids, $categoryId) {
            /** @var Category $category */
            $category = Category::find($categoryId);
            $category->products()->attach($ids);
        });
    }
}
