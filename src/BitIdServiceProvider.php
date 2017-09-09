<?php namespace JoaoJoyce\BitId;

use Illuminate\Support\ServiceProvider;

class BitIdServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Load migrations if needed.
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadViewsFrom(__DIR__.'/../views', 'bitid');
        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        $this->publishes([__DIR__.'/../config/bitid.php' => config_path('bitid.php')]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bitid.php', 'bitid');
    }
}
