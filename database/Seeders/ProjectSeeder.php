<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database Seeders.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Project::class)->create(['author_id' => 2]);
        factory(\App\Models\Project::class)->create();
    }
}
