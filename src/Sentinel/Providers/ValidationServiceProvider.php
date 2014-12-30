<?php namespace Sentinel\Providers;

use Illuminate\Support\ServiceProvider;
use Sentinel\Exceptions\FormValidationFailedException;

class ValidationServiceProvider extends ServiceProvider {

    protected $redirect;

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
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register the FormValidationFailedException handler
        $this->app->error(function( FormValidationFailedException $exception)
        {
            $this->redirect = $this->app->make('redirect');
            return $this->redirect->back()->withInput()->withErrors($exception->getErrors());
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