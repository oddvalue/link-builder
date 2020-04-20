<?php

namespace Oddvalue\LinkBuilder;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LinkBuilderServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('link-builder.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'link-builder');
    }
}
