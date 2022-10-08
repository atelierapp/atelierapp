<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        collect([
            ['name' => 'Burke Decor',],
            ['name' => 'Furbish Studio',],
            ['name' => 'Blue Sky Environments Interior Decor',],
            ['name' => 'Modshop',],
            ['name' => 'Sofamania',],
            ['name' => 'Winnoby',],
            ['name' => 'Eternity Modern',],
            ['name' => 'Boulevard Eight',],
        ])->each(function ($category){
            $currentCategory = Store::whereName($category['name'])->first();
            if (is_null($currentCategory)) {
                Store::factory()->us()->create([
                    'name' => $category['name'],
                    'active' => true,
                ]);
            }
        });
    }
}
