<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::factory()->state(new Sequence(
            ['country' => 'us'],
            ['country' => 'pe'],
        ))->count(10)->create();
    }
}
