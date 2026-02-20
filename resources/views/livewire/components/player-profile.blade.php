<div class="space-y-6">
    <!-- Header con acciones -->
    <x-card>
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold">{{ $player->name }}</h2>
                <p class="text-gray-600">{{ $player->email }}</p>
            </div>

            <div class="flex space-x-2">
                {{-- @can('edit-player-profile')
                    <button wire:click="startEditing" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Editar Perfil
                    </button>
                @endcan

                @can('ban-players')
                    <button wire:click="toggleBan" class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        {{ $player->is_banned ? 'Desbanear' : 'Banear' }}
                    </button>
                @endcan --}}
            </div>
        </div>

        <!-- Stats Cards (visibles para todos con acceso al perfil) -->
        <div class="grid grid-cols-4 gap-4 mt-6">
            <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded text-center">
                <div class="text-xl font-semibold">{{ $playerStats['total_notes'] }}</div>
                <div class="text-sm text-gray-500">Notas</div>
            </div>
            <!-- ... otras stats -->
        </div>
    </x-card>

    <!-- Tabs de navegación -->
    {{-- <div class="border-b border-gray-200 mt-6">
        <nav class="flex space-x-8">
            <button wire:click="changeTab('info')" class="tab {{ $activeTab === 'info' ? 'active' : '' }}">
                Información
            </button>

            @can('view-player-notes')
                <button wire:click="changeTab('notes')" class="tab {{ $activeTab === 'notes' ? 'active' : '' }}">
                    Notas ({{ $playerStats['total_notes'] }})
                </button>
            @endcan

            @can('view-player-purchases')
                <button wire:click="changeTab('purchases')" class="tab {{ $activeTab === 'purchases' ? 'active' : '' }}">
                    Compras
                </button>
            @endcan

            @can('view-player-activity')
                <button wire:click="changeTab('activity')" class="tab {{ $activeTab === 'activity' ? 'active' : '' }}">
                    Actividad
                </button>
            @endcan
        </nav>
    </div> --}}

    <!-- Contenido de las tabs (con verificación adicional) -->
    <div class="mt-6 space-y-6">
        @if ($activeTab === 'info')
            <x-card>@include('livewire.player-profile-sections.tabs.info')</x-card>
        @elseif($activeTab === 'notes' && can('view-player-notes'))
            <livewire:player-notes :player-id="$player->id" wire:key="notes-{{ $player->id }}" />
        @elseif($activeTab === 'purchases' && can('view-player-purchases'))
            <x-card>@include('livewire.player-profile-sections.tabs.purchases')</x-card>
        @elseif($activeTab === 'activity' && can('view-player-activity'))
            <x-card>@include('livewire.player-profile-sections.tabs.activity')</x-card>
        @else
            <x-card>
                <p class="text-center text-gray-500 py-8">
                    No tienes permiso para ver esta sección.
                </p>
            </x-card>
        @endif
    </div>
</div>
