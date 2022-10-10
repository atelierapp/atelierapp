<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StoreSeeder::class
        ]);
    }
}
