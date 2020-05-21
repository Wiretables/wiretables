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
        $this->publishes([
            __DIR__.'/resources/lang/en' => base_path('resources/lang/en'),
        ]);

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/wiretables'),
        ]);
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
