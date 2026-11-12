<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Configuración centralizada de autorización por permisos
        Gate::before(function (User $user, string $ability) {
            // Usuario inactivo -> acceso denegado
            if (!$user->isActive()) {
                return false;
            }

            // Administrador -> acceso irrestricto
            if ($user->isAdmin()) {
                return true;
            }

            // Verifica si el rol asignado al usuario posee el permiso solicitado
            return $user->hasPermission($ability) ? true : false;
        });
    }
}
