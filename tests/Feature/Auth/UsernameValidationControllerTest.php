<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;

class UsernameValidationControllerTest extends \Tests\TestCase
{
    use AdditionalAssertions;
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_can_validate_a_username()
    {

        $data = [
            'username' => $this->faker->lexify('username-????'),
        ];

        $response = $this->postJson(route('username.validate'), $data);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'is_available',
                ],
            ]);
        $response = json_decode($response->getContent(), associative: true);
        $this->assertTrue($response['data']['is_available']);
    }

    /** @test */
    public function it_will_return_false_if_the_username_is_unavailable()
    {
        $user = User::factory()->create([
            'username' => 'existent-user',
        ]);

        $data = [
            'username' => 'existent-user',
        ];

        $response = $this->postJson(route('username.validate'), $data);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'is_available',
                ],
            ]);
        $response = json_decode($response->getContent(), associative: true);
        $this->assertFalse($response['data']['is_available']);
    }
}
