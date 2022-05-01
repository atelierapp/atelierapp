<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Register extends Component
{
    public string $first_name = '';
    public string $email = '';
    public string $username = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected array $rules = [
        'first_name' => 'required|string|min:2',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
    ];

    public function updated($field, $value)
    {
        $checkAll = false;
        if (
            in_array($field, ['username', 'email'])
            && User::where($field, $value)->exists()
        ) {
            $this->dispatchBrowserEvent('existent-user', ['field' => $field]);
        } else {
            $checkAll = true;
        }
        if (
            $checkAll
            && in_array($field, ['username', 'email'])
            && User::where('username', $this->username)->doesntExist()
            && User::where('email', $this->email)->doesntExist()
        ) {
            $this->dispatchBrowserEvent('new-user');
        }
        $this->validateOnly($field);
    }

    public function submit(): void
    {
        $user = User::create($this->validate());
        Auth::login($user);
        $this->redirect('dashboard');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.register');
    }
}
