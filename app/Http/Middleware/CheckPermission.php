<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // 1. Debe estar autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Debes iniciar sesión para acceder.');
        }

        $user = Auth::user();

        // 2. Debe tener la cuenta activa
        if (!$user->isActive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Tu cuenta se encuentra inactiva. Contacta al administrador.');
        }

        // 3. Debe contar con el permiso requerido
        if (!$user->hasPermission($permission)) {
            abort(403, "No dispones del permiso necesario ({$permission}) para realizar esta acción.");
        }

        return $next($request);
    }
}

