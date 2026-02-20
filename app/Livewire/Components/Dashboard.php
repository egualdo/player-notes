<?php

namespace App\Livewire\Components;

use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $players;
    public $selectedPlayer;
    public $currentUserId;

    protected $rules = [
        'selectedPlayer' => 'nullable|exists:users,id',
    ];

    public function mount(): void
    {
        $this->players = Player::all();
        $this->selectedPlayer = null;
        $this->currentUserId = Auth::id();
    }

    public function render()
    {
        return view('livewire.components.dashboard')
            ->layout('layouts.app');
    }
}
