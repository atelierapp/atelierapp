<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BouncerSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StyleSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(UnitSystemSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(MediaTypeSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(MediaSeeder::class);
        $this->call(RoomSeeder::class);
    }
}
