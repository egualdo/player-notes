<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('dashboard', \App\Livewire\Components\Dashboard::class);
        Livewire::component('player-notes', \App\Livewire\Components\PlayerNotes::class);
    }
}
