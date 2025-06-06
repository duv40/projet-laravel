<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// D'autres imports peuvent être présents par défaut selon la version, comme pour la pagination Bootstrap, etc.
// use Illuminate\Pagination\Paginator;

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
        // Exemple de ce qui pourrait être là par défaut (selon la version de Laravel) :
        // Paginator::useBootstrapFive(); // ou useBootstrapFour() ou useBootstrap()
    }
}