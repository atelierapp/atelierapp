<?php

namespace Database\seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Bouncer;

class BouncerSeeder extends Seeder
{
    public function run(): void
    {
        Bouncer::allow('user')->toOwn(Project::class);
    }
}
