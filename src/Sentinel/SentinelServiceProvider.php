<?php namespace Sentinel;

use Sentinel\Repo\RepoServiceProvider;
use Sentinel\Service\Form\FormServiceProvider;
use Illuminate\Support\ServiceProvider;

class SentinelServiceProvider extends ServiceProvider {

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
		// Load the package
		$this->package('rydurham/sentinel');

        // Register the Sentry Service Provider
        $this->app->register('Cartalyst\Sentry\SentryServiceProvider');

        // Add the Views Namespace 
        if (is_dir(app_path().'/views/packages/rydurham/sentinel'))
        {
        	// The package views have been published - use those views. 
        	$this->app['view']->addNamespace('Sentinel', array(app_path().'/views/packages/rydurham/sentinel'));
        }
        else 
        {
        	// The package views have not been published. Use the defaults. 
        	$this->app['view']->addNamespace('Sentinel', __DIR__.'/../views');
        }

        // Add the Sentinel Namespace to $app['config']
        if (is_dir(app_path().'/config/packages/rydurham/sentinel'))
        {
        	// The package config has been published
        	$this->app['config']->addNamespace('Sentinel', app_path().'/config/packages/rydurham/sentinel');
        }
        else
        {
        	// The package config has not been published.
        	$this->app['config']->addNamespace('Sentinel', __DIR__.'/../config');
        }

        

        // Add the Translator Namespace
        $this->app['translator']->addNamespace('Sentinel', __DIR__.'/../lang');


        // Make the app aware of these files
		include __DIR__ . '/../routes.php';
        include __DIR__ . '/../filters.php';
        include __DIR__ . '/../observables.php';

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Sentry', 'Cartalyst\Sentry\Facades\Laravel\Sentry');

		$repoProvider = new RepoServiceProvider($this->app);
        $repoProvider->register();

        $formServiceProvider = new FormServiceProvider($this->app);
        $formServiceProvider->register();
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