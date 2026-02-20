<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount()
    {
        if (Auth::check()) {
            // if already authenticated, send to dashboard instead of looping
            redirect()->intended('/dashboard');
        }
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function login()
    {
        $this->validate();
        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            session()->regenerate();
            // redirect to the page the user intended or to the home/dashboard
            return redirect()->intended('/dashboard');
        }

        $this->addError('email', __('auth.failed'));
    }

    public function render()
    {
        // use the main application layout so navigation/structure is consistent
        return view('livewire.auth.login')
            ->layout('layouts.app');
    }
}
