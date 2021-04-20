<?php

namespace Tests\Feature\Http\Controllers;

use Database\Seeders\ColorSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProjectController
 */
class ColorControllerTest extends TestCase
{
    use AdditionalAssertions;
    use WithFaker;

    /**
     * @test
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
    }
}
