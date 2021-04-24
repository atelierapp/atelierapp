<?php

namespace Tests\Feature\Http\Controllers;

use Database\Seeders\ColorSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @title Colors
 * @see \App\Http\Controllers\ProjectController
 */
class ColorControllerTest extends TestCase
{
    use AdditionalAssertions;
    use WithFaker;

    /**
     * @test
     * @title List colors
     */
    public function it_can_list_colors()
    {
        $this->seed(ColorSeeder::class);
        $response = $this->getJson(route('colors.index'));
        $response
            ->assertOk()
            ->assertJsonStructure([
                [
                    'brand',
                    'items',
                ],
            ]);

        $this->markTestIncomplete('It should paginate the list.');
    }
}
