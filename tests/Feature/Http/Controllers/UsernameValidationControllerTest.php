<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsernameValidationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @title User available
     */
    public function it_will_return_true_if_the_username_is_available()
    {
        User::factory()->create([
            'username' => 'john.Doe_',
        ]);

        $response = $this->post(route('validateUsername'), [
            'username' => 'jane_doe',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['is_available' => true]);
    }

    /**
     * @test
     * @title User unavailable
     */
    public function it_will_return_false_if_the_username_is_not_available()
    {
        User::factory()->create([
            'username' => 'john.Doe_',
        ]);

        $response = $this->post(route('validateUsername'), [
            'username' => 'JohnDoe_',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['is_available' => false]);
    }
}
