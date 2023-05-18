<?php

namespace App\Providers;

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
        $loader = new \Twig\Loader\FilesystemLoader();
        $loader->addPath(base_path() . '/resources/views/components', 'components');
        \Twig::getLoader()->addLoader($loader);
    }
}
