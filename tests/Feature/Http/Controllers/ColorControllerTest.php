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
            ->assertJsonStructure(
                [
                    [
                        'brand',
                        'items' => [
                            'data' => [
                                0 => [
                                    'id',
                                    'name',
                                    'hex',
                                    'url',
                                    'active',
                                    'created_at',
                                    'updated_at'
                                ],
                            ],
                            'current_page',
                            'first_page_url',
                            'from',
                            'last_page',
                            'last_page_url',
                            'next_page_url',
                            'path',
                            'per_page',
                            'prev_page_url',
                            'to',
                            'total',
                        ],
                    ],
                ]
            );
    }
}
