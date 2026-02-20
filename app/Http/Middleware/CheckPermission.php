<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!Auth::check()) {
            abort(403, 'No autenticado');
        }

        if (!Auth::user()->can($permission)) {
            abort(403, 'No tienes permiso para realizar esta acción');
        }

        return $next($request);
    }
}
