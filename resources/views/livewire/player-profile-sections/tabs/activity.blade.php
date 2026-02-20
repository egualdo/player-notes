<div class="space-y-4">
    <h3 class="text-lg font-semibold mb-3">Actividad Reciente</h3>

    @if (count($recentActivity) > 0)
        <div class="flow-root">
            <ul class="-mb-8">
                @foreach ($recentActivity as $index => $activity)
                    <li>
                        <div class="relative pb-8">
                            @if (!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                    aria-hidden="true"></span>
                            @endif

                            <div class="relative flex space-x-3">
                                <div>
                                    <span
                                        class="h-8 w-8 rounded-full bg-{{ $activity['color'] }}-100 flex items-center justify-center">
                                        <span>{{ $activity['icon'] }}</span>
                                    </span>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="text-sm text-gray-500">
                                        <span class="font-medium text-gray-900">{{ $activity['description'] }}</span>
                                    </div>

                                    @if (isset($activity['content']))
                                        <p class="mt-1 text-sm text-gray-700">{{ $activity['content'] }}</p>
                                    @endif

                                    @if (isset($activity['duration']))
                                        <p class="mt-1 text-sm text-gray-500">Duración: {{ $activity['duration'] }}</p>
                                    @endif

                                    <div class="mt-1 text-xs text-gray-400">
                                        {{ $activity['time'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <p class="text-gray-500 text-center py-8">No hay actividad reciente para mostrar.</p>
    @endif
</div>
