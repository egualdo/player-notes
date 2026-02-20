<!-- Header -->
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold">Notas del jugador</h3>

        @if ($canCreate)
            <button wire:click="changeModal" wire:loading.attr="disabled"
                class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50 text-sm"
                type="button">
                <span wire:loading.remove wire:target="changeModal">+ Nueva Nota</span>
                <span wire:loading wire:target="changeModal">Procesando...</span>
            </button>
        @endif
    </div>

    <!-- Modal para nueva nota -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center z-50" wire:key="modal-{{ time() }}">
            <!-- Fondo oscuro - SOLO ESTO CIERRA EL MODAL -->
            <div class="fixed inset-0 bg-black opacity-50" wire:click="changeModal"></div>

            <!-- Contenido del modal - SIN evento de click para que no se cierre -->
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md mx-auto z-10 p-6">
                <h2 class="text-xl font-semibold mb-4">Agregar nueva nota</h2>

                <form wire:submit.prevent="saveNote">
                    <div class="mb-4">
                        <label for="newNote" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Contenido de la nota
                        </label>
                        <textarea id="newNote" wire:model="newNote" rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('newNote') border-red-500 @enderror"
                            placeholder="Escribe tu observación aquí..." maxlength="1000" autofocus></textarea>

                        @error('newNote')
                            <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror

                        <div class="text-xs text-gray-500 mt-1 text-right">
                            {{ strlen($newNote) }}/1000 caracteres
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="changeModal" wire:loading.attr="disabled"
                            class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 disabled:opacity-50">
                            Cancelar
                        </button>

                        <button type="submit" wire:loading.attr="disabled" wire:target="saveNote"
                            class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white rounded disabled:opacity-50">
                            <span wire:loading.remove wire:target="saveNote">Guardar Nota</span>
                            <span wire:loading wire:target="saveNote">Guardando...</span>
                        </button>
                    </div>
                </form>

                <!-- Botón de cierre opcional en la esquina -->
                <button type="button" wire:click="changeModal"
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Listado de notas -->
    <div class="space-y-3" wire:key="notes-list-{{ $playerId }}-{{ $notes->currentPage() }}">
        @forelse($notes as $note)
            <div
                class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-sm transition-shadow">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex items-center space-x-2">
                        <span class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $note->author->name }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $note->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>

                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line text-sm">
                    {{ $note->content }}
                </p>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-lg">
                No hay notas para este jugador.
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if ($notes->hasPages())
        <div class="mt-4">
            {{ $notes->links() }}
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            // Notificaciones simples
            Livewire.on('note-saved', (event) => {
                const message = event[0]?.message || event?.message || 'Nota guardada correctamente';

                // Crear notificación temporal
                const notification = document.createElement('div');
                notification.className =
                    'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50 animate-fade-in';
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            });

            Livewire.on('note-error', (event) => {
                const message = event[0]?.message || event?.message || 'Error al guardar la nota';

                const notification = document.createElement('div');
                notification.className =
                    'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow-lg z-50 animate-fade-in';
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            });
        });
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
@endpush
