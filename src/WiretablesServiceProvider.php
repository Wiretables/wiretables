<?php

namespace Wiretables;

use \Illuminate\Support\ServiceProvider;

class WiretablesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'wiretables');

        $this->loadViewsFrom(__DIR__.'/views', 'wiretables');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Commands\MakeComponent::class
        ]);
    }

}
