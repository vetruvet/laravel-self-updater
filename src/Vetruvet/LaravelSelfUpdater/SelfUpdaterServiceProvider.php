<?php 

namespace Vetruvet\LaravelSelfUpdater;

use Config;
use Route;
use Illuminate\Support\ServiceProvider;

class SelfUpdaterServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('vetruvet/laravel-self-updater', 'self-updater');
        
        Route::get(Config::get('self-updater::routes.manual', '/trigger_update'), array(
                'before' => Config::get('self-updater::routes.manual_filter', null),
                'uses' => 'Vetruvet\LaravelSelfUpdater\UpdateController@triggerManualUpdate',
            ));
        Route::post(Config::get('self-updater::routes.auto', '/trigger_update'), array(
                'uses' => 'Vetruvet\LaravelSelfUpdater\UpdateController@triggerAutoUpdate',
            ));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() { }

}
