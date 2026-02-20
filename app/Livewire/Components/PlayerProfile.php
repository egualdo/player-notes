<?php

namespace App\Livewire\Components;

use App\Models\Player;
use App\Repositories\Interfaces\PlayerNoteRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PlayerProfile extends Component
{
    use WithPagination;

    public Player $player;
    public array $playerStats = [];
    public string $activeTab = 'info';

    // Para edición
    public bool $editing = false;
    public string $editableName = '';
    public string $editableEmail = '';

    protected $listeners = [
        'noteAdded' => 'refreshNotes',
        'profileUpdated' => 'refreshProfile'
    ];

    protected PlayerNoteRepositoryInterface $noteRepository;

    public function __construct($id = null)
    {
        // parent::__construct($id);
        $this->noteRepository = app(PlayerNoteRepositoryInterface::class);
    }

    public function mount(int $playerId): void
    {
        $this->player = Player::findOrFail($playerId);
        $this->loadPlayerStats();
        $this->editableName = $this->player->name;
        $this->editableEmail = $this->player->email;
    }

    protected function loadPlayerStats(): void
    {
        $this->playerStats = [
            'total_notes' => $this->player->notes()->count(),
            // 'total_sessions' => $this->player->sessions()->count(),
            // 'total_purchases' => $this->player->purchases()->count(),
            // 'total_spent' => $this->player->purchases()->sum('amount'),
        ];
    }

    public function changeTab(string $tab): void
    {
        // Verificar permisos para cada pestaña
        $permissionMap = [
            'notes' => 'view-player-notes',
            'purchases' => 'view-player-purchases',
            'activity' => 'view-player-activity',
            'info' => 'view-player-profile',
        ];

        if (isset($permissionMap[$tab]) && !Auth::user()->can($permissionMap[$tab])) {
            session()->flash('error', 'No tienes permiso para ver esta sección.');
            return;
        }

        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function startEditing(): void
    {
        if (!Auth::user()->can('edit-player-profile')) {
            session()->flash('error', 'No tienes permiso para editar perfiles.');
            return;
        }
        $this->editing = true;
    }

    public function saveProfile(): void
    {
        if (!Auth::user()->can('edit-player-profile')) {
            session()->flash('error', 'No tienes permiso para editar perfiles.');
            return;
        }

        $this->validate([
            'editableName' => 'required|string|max:255',
            'editableEmail' => 'required|email|unique:users,email,' . $this->player->id,
        ]);

        try {
            $this->player->update([
                'name' => $this->editableName,
                'email' => $this->editableEmail,
            ]);

            $this->editing = false;
            $this->emit('profileUpdated');
            $this->dispatchBrowserEvent('profile-saved', ['message' => 'Perfil actualizado.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('profile-error', ['message' => 'Error al guardar.']);
        }
    }

    public function toggleBan(): void
    {
        if (!Auth::user()->can('ban-players')) {
            session()->flash('error', 'No tienes permiso para banear jugadores.');
            return;
        }

        // Lógica de ban...
    }

    public function refreshNotes(): void
    {
        if (Auth::user()->can('view-player-notes')) {
            $this->loadPlayerStats();
        }
    }

    public function render()
    {
        return view('livewire.components.player-profile', [
            'canEdit' => Auth::check() && Auth::user()->can('edit-player-profile'),
            'canBan' => Auth::check() && Auth::user()->can('ban-players'),
            'canViewNotes' => Auth::check() && Auth::user()->can('view-player-notes'),
            'notes' => $this->activeTab === 'notes' && $this->canViewNotes
                ? $this->noteRepository->getForPlayer($this->player->id, 10)
                : null,
        ]);
    }
}
