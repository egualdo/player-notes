    <!-- header -->
    <div class="max-w-6xl mx-auto p-6 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-card>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-medium">Mi perfil</h2>
                    </div>

                    <div class="flex items-start gap-6">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-xl font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-lg font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </x-card>

                @can('create-player-notes')
                    <x-card>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-medium">Agregar nota a otro jugador</h2>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-end gap-4">
                            <div class="flex-1">
                                <label for="selectedPlayer" class="block text-sm font-medium text-gray-700 mb-1">
                                    Jugador
                                </label>
                                <select wire:model.live="selectedPlayer" id="selectedPlayer"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">Selecciona un jugador</option>
                                    @foreach ($players as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} &lt;{{ $p->email }}&gt;
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if ($selectedPlayer)
                            <div class="mt-6" wire:key="player-notes-wrapper-{{ $selectedPlayer }}">
                                @livewire('player-notes', ['playerId' => $selectedPlayer], key('notes-' . $selectedPlayer))
                            </div>
                        @else
                            <div class="mt-6 text-sm text-gray-500">
                                Selecciona un jugador para ver y agregar notas.
                            </div>
                        @endif
                    </x-card>
                @endcan
            </div>
        </div>
    </div>
