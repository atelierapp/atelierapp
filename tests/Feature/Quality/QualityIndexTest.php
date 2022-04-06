<?php

namespace Tests\Feature\Quality;

use Database\Seeders\QualitySeeder;
use Tests\TestCase;

class QualityIndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(QualitySeeder::class);
    }

    public function test_a_guess_user_can_list_all_qualities()
    {
        $response = $this->getJson(route('quality.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }
}
