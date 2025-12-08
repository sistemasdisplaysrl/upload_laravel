<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Ajuste;

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
        // Forzar HTTPS cuando está detrás de un proxy
        if (env('APP_FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        try {
            $ajustes = Ajuste::first();
            view()->share('ajustes', $ajustes);
        } catch (\Exception $e) {
            // Evitar error si la base de datos no está lista (ej. durante composer install)
        }
    }
}
