<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call([
            MediaTypeSeeder::class,
            ColorSeeder::class,
            StyleSeeder::class,
            CategorySeeder::class,
            QualitySeeder::class,
            OrderStatusSeeder::class,
            PaymentStatusSeeder::class,

            BouncerSeeder::class,
            RoleSeeder::class,
        ]);
    }

}
