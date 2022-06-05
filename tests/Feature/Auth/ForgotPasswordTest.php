<?php

namespace Tests\Feature\Auth;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    public function test_a_guess_user_cannot_recover_password_without_email()
    {
        $response = $this->postJson(route('forgotPassword'));

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'email'
        ]);
    }

    public function test_a_guess_user_can_recover_password_if_email_exits()
    {
        Mail::fake();
        $email = User::factory()->create()->email;
        $response = $this->postJson(route('forgotPassword', ['email' => $email]));

        $response->assertOk();
        $this->assertDatabaseHas('password_resets', ['email' => $email]);
        Mail::assertSent(ForgotPasswordMail::class);
    }

    public function test_a_guess_user_can_get_a_200_status_code_when_send_invalid_email_but_recover_email_is_not_Send()
    {
        Mail::fake();
        $email = 'someemail@domain.com';
        $response = $this->postJson(route('forgotPassword', ['email' => $email]));

        $response->assertOk();
        $this->assertDatabaseMissing('password_resets', ['email' => $email]);
        Mail::assertNotSent(ForgotPasswordMail::class);
    }
}
