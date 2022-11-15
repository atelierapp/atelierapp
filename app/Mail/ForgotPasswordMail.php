<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        private string $name,
        private string $token
    ) {
    }

    public function build(): ForgotPasswordMail
    {
        return $this
            ->markdown('emails.recover-password', [
                'name' => $this->name,
                'token' => $this->token,
            ])
            ->subject(__('email.recover-your-password'));
    }
}
