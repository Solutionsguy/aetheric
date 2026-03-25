<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\AppInstall;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {}

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (AppInstall::dbConnectionCheck()) {
            $views = __DIR__.'/../../resources/views/frontend/'.site_theme();
            $this->loadViewsFrom($views, 'frontend');
        }

    }
}
