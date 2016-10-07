<?php namespace darrenmerrett\ReactTag;

use Illuminate\Support\ServiceProvider;
use Conner\Tagging\Contracts\TaggingUtility;
use Conner\Tagging\Util;

/**
 * Copyright (C) 2014 Robert Conner
 */
class ReactTagServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {

        $this->publishes([
            __DIR__.'/../../../rtconner/laravel-tagging/migrations/' => database_path('migrations')
        ], 'migrations');
        
        $this->publishes([
            __DIR__.'/./migrations/' => database_path('migrations')
        ], 'migrations');

    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/Config/tagging.php', 'tagging');

        $this->app->singleton(TaggingUtility::class, function () {
            return new Util;
        });

    }
    
    /**
     * (non-PHPdoc)
     * @see \Illuminate\Support\ServiceProvider::provides()
     */
    public function provides()
    {
        return [TaggingUtility::class];
    }

}
