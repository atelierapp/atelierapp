<?php

namespace App\Http\Livewire;

use App\Models\ShopContact;
use Livewire\Component;

class ShopRegistrationForm extends Component
{
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $company = '';
    public string $position = '';
    public string $about = '';
    public string $website = '';
    public bool $registered = false;

    protected $rules = [
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => ['required', 'email'],
        'phone' => ['required', 'numeric' ,'digits_between:7,11'],
        'address' => ['required', 'min:5'],
        'company' => 'required',
        'position' => 'required',
        'about' => 'required',
        'website' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        ShopContact::create([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'company' => $this->company,
            'position' => $this->position,
            'about' => $this->about,
            'website' => $this->website,
        ]);

        $this->registered = true;
    }

    public function render()
    {
        return view('livewire.shop-registration-form');
    }
}
