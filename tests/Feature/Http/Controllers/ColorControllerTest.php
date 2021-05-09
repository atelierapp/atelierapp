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

    private function structure(): array
    {
        return [
            'id',
            'name',
            'hex',
            'url',
            'active',
            'created_at',
            'updated_at'
        ];
    }

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
                'brand',
                'data' => [
                    0 => $this->structure(),
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ]
            ]);
    }
}
