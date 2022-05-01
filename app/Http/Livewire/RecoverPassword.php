<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\Messages\MailMessage;
use Livewire\Component;

class RecoverPassword extends Component
{
    public string $username = '';
    protected array $rules = [
      'username' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit(): void
    {
        $data = $this->validate();
        if (! User::firstByEmailOrUsername($data['username'])) {
         return;
        }
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            return (new MailMessage())
                ->subject(__('Reset Password Notification'))
                ->line(__('You are receiving this email because we received a password reset request for your account.'))
                ->action(__('Reset Password'), route('nova.password.reset', $token))
                ->line(__('If you did not request a password reset, no further action is required.'));
        });
        $this->dispatchBrowserEvent('recovery-email-has-been-sent');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.recover-password');
    }
}
