<?php

namespace Owenzhou\LaravelAsset;

use Illuminate\Support\ServiceProvider;

class AssetsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(base_path('resources/views/themes'), 'Themes');
		$this->publishes([
			__DIR__.'/views' => base_path('resources/views'),	
		]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
		$this->app->singleton('assets', function($app){
			return new Assets();
		});
    }
}
