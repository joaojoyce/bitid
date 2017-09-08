<?php namespace joaojoyce\bitid;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use joaojoyce\bitid\Auth\BitIdUserProvider;

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

        Auth::provider('bitid', function ($app, array $config) {
            return new BitIdUserProvider();
        });

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
