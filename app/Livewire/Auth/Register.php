<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


#[Layout('layouts.loginoutnav', ['title' => 'Register'])]
class Register extends Component
{
    public $fullName;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'fullName' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {

        $validatedData = $this->validate();

        $user = User::create([
            'name' => $validatedData['fullName'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::login($user);
        request()->session()->regenerate();


        return redirect()->route('user.menu')->with('success', 'Account created successfully!');
    }

    public function render()
    {

        return view('livewire.auth.register');
    }
}
