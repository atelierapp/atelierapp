<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Quality;
use App\Models\Store;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DatabasePeSeeder extends Seeder
{
    public function run(): void
    {
        $locale = config('app.locale');
        $country = config('app.country');
        \App::setLocale('es');
        config(['app.country' => 'pe']);

        $this->call([
            UserPeSeeder::class,
            PeruSeeder::class,
        ]);

        \App::setLocale($locale);
        config(['app.country' => $country]);
    }
}
