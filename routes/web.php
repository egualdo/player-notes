<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    // Rutas protegidas por permisos usando middleware
    Route::get('/players/{player}', \App\Livewire\Components\PlayerProfile::class)
        ->name('players.show')
        ->middleware('permission:view-player-profile');

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

// Grupo de rutas para administración
Route::middleware(['auth', 'permission:manage-roles'])->prefix('admin')->group(function () {
    // Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles');
    // Route::get('/permissions', [PermissionController::class, 'index'])->name('admin.permissions');
});
