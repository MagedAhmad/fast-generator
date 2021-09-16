<?php

namespace MagedAhmad\SpeedGenerator;

use Illuminate\Support\ServiceProvider;
use MagedAhmad\SpeedGenerator\Console\Commands\CrudMakeCommand;

class SpeedGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'speed-generator');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'speed-generator');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/speed-generator.php' => config_path('speed-generator.php'),
            ], 'speed-generator');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/speed-generator'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/speed-generator'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/speed-generator'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([
                CrudMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/speed-generator.php', 'speed-generator');

        // Register the main class to use with the facade
        $this->app->singleton('speed-generator', function () {
            return new SpeedGenerator;
        });
    }
}
