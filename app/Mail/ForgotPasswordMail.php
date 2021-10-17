<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function build(): ForgotPasswordMail
    {
        return $this
            ->view('emails.recoverPassword')
            ->subject('Recover your password')
            ->with(['token' => $this->token]);
    }
}
