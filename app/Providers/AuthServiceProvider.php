<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    // public function boot(): void
    // {
    //     $this->registerPolicies();

    //     Gate::define('view-player-profile', fn($user) => $user->hasRole(['admin', 'support_agent']));
    //     Gate::define('edit-player-profile', fn($user) => $user->hasRole(['admin', 'support_manager']));
    //     Gate::define('ban-players', fn($user) => $user->hasRole(['admin', 'support_manager']));
    //     Gate::define('view-player-notes', fn($user) => $user->hasRole(['admin', 'support_agent']));
    // }
}
