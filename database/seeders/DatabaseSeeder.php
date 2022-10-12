<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(MediaTypeSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(StyleSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(QualitySeeder::class);

        $this->call(BouncerSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(DatabaseUsSeeder::class);

        // if (app()->environment(['local', 'staging'])) {
        //     $this->call(TagSeeder::class);
        //     $this->call(MaterialSeeder::class);
        //     $this->call(UnitSystemSeeder::class);
        //     $this->call(UnitSeeder::class);
        //     $this->call(ProjectSeeder::class);
        //     $this->call(MediaSeeder::class);
        //     $this->call(RoomSeeder::class);
        // }
    }

}
