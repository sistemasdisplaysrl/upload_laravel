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
        $ajustes = Ajuste::first();
        view()->share('ajustes', $ajustes);
    }
}
