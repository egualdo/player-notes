<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Livewire assets --}}
    @livewireStyles
</head>

<body class="flex h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    @auth
        <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col">
            <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
                <span class="text-xl font-bold">PN</span>
            </div>
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                    <span class="ml-3">Dashboard</span>
                </a>
                {{-- otros enlaces --}}
            </nav>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <a href="#" onclick="event.preventDefault();document.getElementById('logout').submit()"
                    class="flex items-center px-3 py-2 text-red-600 hover:bg-red-100 dark:hover:bg-red-900 rounded-lg">
                    <span class="ml-3">Cerrar sesión</span>
                </a>
                <form id="logout" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </aside>
    @endauth
    <div class="flex-1 flex flex-col">
        @auth
            <header
                class="h-16 flex items-center justify-between px-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <button class="md:hidden text-gray-500" id="btn-sidebar-toggle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </header>
        @endauth
        <main class="flex-1 overflow-y-auto p-6">
            {{-- render Livewire component output when using ->layout() --}}
            {{ $slot ?? '' }}

            {{-- fallback for regular blade views using sections --}}
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    {{-- Livewire scripts --}}
    @livewireScripts
</body>

</html>
