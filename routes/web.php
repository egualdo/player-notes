<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rutas protegidas por permisos usando middleware
Route::middleware(['auth'])->group(function () {

    // API interna para Livewire (las rutas Livewire se protegen en el componente)
    Route::get('/dashboard', \App\Livewire\Components\Dashboard::class)
        ->name('dashboard');

    Route::post('/logout', function () {
        // manual logout route
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

// Rutas de autenticación usando Livewire
Route::middleware('guest')->group(function () {
    // raíz de la aplicación muestra el formulario de login
    Route::get('/', \App\Livewire\Auth\Login::class)
        ->name('login');
});
