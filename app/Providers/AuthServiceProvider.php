<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $policies = [
        \App\Models\Producto::class => \App\Policies\ProductoPolicy::class,
        \App\Models\Compra::class => \App\Policies\CompraPolicy::class,
        \App\Models\Venta::class => \App\Policies\VentaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //Gates para roles generales
        Gate::define('manage-all', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('create-compras', function ($user) {
            return $user->role === 'comprador';
        });

        Gate::define('create-ventas', function ($user) {
            return $user->role === 'vendedor';
        });

        Gate::define('delete-ventas', function ($user) {
            return $user->role === 'vendedor';
        });

        Gate::define('delete-compras', function ($user) {
            return $user->role === 'comprador';
        });
    }
}
