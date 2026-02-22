<?php

namespace App\Livewire\Components;

use App\Models\PlayerNote;
use App\Repositories\Interfaces\PlayerNoteRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PlayerNotes extends Component
{
    use WithPagination;

    public int $playerId;
    public string $newNote = '';
    public bool $showModal = false;

    protected PlayerNoteRepositoryInterface $noteRepository;

    public function boot(PlayerNoteRepositoryInterface $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function mount(int $playerId): void
    {
        $this->playerId = $playerId;
        $this->showModal = false;
    }

    public function changeModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function saveNote()
    {
        if (!Auth::user()->can('create-player-notes')) {
            $this->dispatch('note-error', message: 'No tienes permiso para crear notas');
            return;
        }

        $this->validate([
            'newNote' => 'required|min:3|max:1000'
        ]);

        try {
            PlayerNote::create([
                'player_id' => $this->playerId,
                'author_id' => Auth::id(),
                'content' => $this->newNote
            ]);

            $this->reset('newNote');
            $this->showModal = false;

            $this->dispatch('note-saved', message: 'Nota guardada correctamente');
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch('note-error', message: 'Error al guardar la nota');
        }
    }

    public function render()
    {
        $notes = $this->noteRepository->getForPlayer($this->playerId, 3);

        return view('livewire.components.player-notes', [
            'notes' => $notes,
            'canCreate' => Auth::check() && Auth::user()->can('create-player-notes')
        ]);
    }
}
