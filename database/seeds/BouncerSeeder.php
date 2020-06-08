<?php

use App\Models\Project;
use Illuminate\Database\Seeder;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::ownedVia(Project::class, 'author_id');
        Bouncer::allow('user')->toOwn(Project::class);
    }
}
