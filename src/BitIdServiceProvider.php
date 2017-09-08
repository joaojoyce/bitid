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

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
