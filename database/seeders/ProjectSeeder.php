<?php

namespace Database\seeders;

use App\Models\Project;
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
        Project::factory()->create(['author_id' => 2]);
        Project::factory()->create();
    }
}
