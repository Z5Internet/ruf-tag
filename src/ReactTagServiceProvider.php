<?php namespace z5internet\ReactTag;

use Illuminate\Support\ServiceProvider;
use Conner\Tagging\Contracts\TaggingUtility;
use Conner\Tagging\Util;

use GraphQL;

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
            $this->configPath() => config_path('DM/react-tag.php'),
        ]);

        $this->publishes([
            __DIR__.'/../../../rtconner/laravel-tagging/migrations/' => database_path('migrations')
        ], 'migrations');
        
        $this->publishes([
            __DIR__.'/./migrations/' => database_path('migrations')
        ], 'migrations');

        if (! $this->app->routesAreCached()) {
            
            require __DIR__.'/routes/data.php';
            
        }

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

        $this->mergeConfigFrom($this->configPath(), 'DM/react-tag');

        if (array_get(config('DM.react-tag'),'tag_batches')) {

            foreach (config('DM.react-tag')['tag_batches'] as $key => $value) {

                config(['DM.react-tag.tag_batches.'.$key.'.slug' => str_slug($value['name'])]);

            }

        }

    }
    
    /**
     * (non-PHPdoc)
     * @see \Illuminate\Support\ServiceProvider::provides()
     */
    public function provides()
    {
        return [TaggingUtility::class];
    }

    protected function configPath()
    {
        
        return __DIR__.'/installationFiles/config/react-tag.php';
        
    }

}
