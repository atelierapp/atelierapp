<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    protected array $rules = [
        'password' => 'required|min:6',
        'email' => 'required|email',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit(): void
    {
        $validated = $this->validate();
        $loggedIn = Auth::attempt($validated);
        if (! $loggedIn) {
            $this->dispatchBrowserEvent('invalid-credentials');

            return;
        }
        $this->redirect(route('dashboard'));
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.login');
    }
}
