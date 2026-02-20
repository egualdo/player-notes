<div class="space-y-6">
    <!-- Información de contacto -->
    <div>
        <h3 class="text-lg font-semibold mb-3">Información de Contacto</h3>
        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded">
            <div>
                <span class="text-sm text-gray-500">Email:</span>
                <span class="ml-2 text-gray-900">{{ $player->email }}</span>
            </div>
            <div>
                <span class="text-sm text-gray-500">Teléfono:</span>
                <span class="ml-2 text-gray-900">{{ $player->profile?->phone ?? 'No registrado' }}</span>
            </div>
            <div>
                <span class="text-sm text-gray-500">País:</span>
                <span class="ml-2 text-gray-900">{{ $player->profile?->country ?? 'No registrado' }}</span>
            </div>
            <div>
                <span class="text-sm text-gray-500">Idioma:</span>
                <span class="ml-2 text-gray-900">{{ $player->profile?->language ?? 'Español' }}</span>
            </div>
        </div>
    </div>


</div>
