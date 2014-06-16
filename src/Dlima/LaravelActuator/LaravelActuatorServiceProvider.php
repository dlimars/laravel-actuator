<?php

namespace Dlima\LaravelActuator;

use Illuminate\Support\ServiceProvider;

class LaravelActuatorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    public function boot()
    {
        $this->package("dlima/actuator");
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['router']->any('health', __NAMESPACE__.'\ActuatorController@health');
        $this->app['router']->any('metrics', __NAMESPACE__.'\ActuatorController@metrics');

        $app = &$this->app;

        $this->app->down(function() use ($app) {
            $actuator = $app->make(__NAMESPACE__.'\ActuatorController');
            return $actuator->responseWhenDown();
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
