<?php

namespace Database\Seeders;

use App\Models\Project;
use Bouncer;
use Illuminate\Database\Seeder;

class BouncerSeeder extends Seeder
{
    public function run(): void
    {
        Bouncer::allow('user')->toOwn(Project::class);
    }
}
