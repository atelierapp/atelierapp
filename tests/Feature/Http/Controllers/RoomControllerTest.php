<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RoomController
 */
class RoomControllerTest extends TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        Room::factory()->count(3)->create();

        $response = $this->get(route('room.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RoomController::class,
            'store',
            \App\Http\Requests\RoomStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $data = [
            'name' => $this->faker->word,
            'dimensions' => ['alto' => 2.10,],
            'doors' => ['cuarto' => 5,],
            'framing' => ['alto' => 2.10,],
        ];

        $response = $this->postJson(route('room.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([]);

        // $this->assertDatabaseHas(
        //     'rooms',
        //     [
        //         'dimensions->alto' => $data['dimensions']['alto'],
        //         'framing->alto' => $data['dimensions']['alto'],
        //     ]
        // );
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $room = Room::factory()->create();

        $response = $this->get(route('room.show', $room));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RoomController::class,
            'update',
            \App\Http\Requests\RoomUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $room = Room::factory()->create();
        $data = [
            'dimensions' => [
                'alto' => 2.10,
            ],
            'framing' => [
                'alto' => 2.10,
            ],
        ];

        $response = $this->putJson(route('room.update', $room), $data);

        $response->assertOk();
        $response->assertJsonStructure([]);

        // $this->assertDatabaseHas(
        //     'rooms',
        //     [
        //         'dimensions->alto' => $data['dimensions']['alto'],
        //         'framing->alto' => $data['dimensions']['alto'],
        //     ]
        // );
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $room = Room::factory()->create();

        $response = $this->delete(route('room.destroy', $room));

        $response->assertNoContent();

        $this->assertDeleted($room);
    }
}
