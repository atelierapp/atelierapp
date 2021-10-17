<?php

namespace Tests\Feature\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\ForgotPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RecoverPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guess_can_recover_password_by_email_if_this_exists_and_sent_email()
    {
        Mail::fake();
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
        ];
        $response = $this->postJson(route('forgotPassword'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'data'
        ]);
        $this->assertEquals(__('passwords.sent'), $response->json('message'));
        $this->assertDatabaseHas(ForgotPassword::class, ['email' => $user->email]);
        Mail::assertSent(ForgotPasswordMail::class);
    }

    public function test_a_guess_cannot_recover_password_by_email_if_not_exists_and_dont_sent_email()
    {
        Mail::fake();

        $data = [
            'email' => 'not_exists_mail@domain.com'
        ];
        $response = $this->postJson(route('forgotPassword'), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'data'
        ]);
        $this->assertEquals(__('passwords.sent'), $response->json('message'));
        $this->assertDatabaseMissing(ForgotPassword::class, ['email' => $data['email']]);
        Mail::assertNotSent(ForgotPasswordMail::class);
    }

    public function test_a_guess_cannot_recover_password_without_email_param()
    {
        $data = [
        ];
        $response = $this->postJson(route('forgotPassword'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email'
        ]);
        $this->assertEquals('The email field is required.', $response->json('errors.email.0'));
    }

    public function test_a_guess_cannot_recover_password_with_invalid_email_param()
    {
        $data = [
            'email' => 'invalid-email'
        ];
        $response = $this->postJson(route('forgotPassword'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email'
        ]);
        $this->assertEquals('The email must be a valid email address.', $response->json('errors.email.0'));
    }
}
