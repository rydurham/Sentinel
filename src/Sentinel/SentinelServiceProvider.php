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
		$this->package('rydurham/sentinel');
		include __DIR__ . '/../routes.php';
        include __DIR__ . '/../filters.php';
        include __DIR__ . '/../observables.php';

        $this->app->register('Cartalyst\Sentry\SentryServiceProvider');

        $this->app['view']->addNamespace('Sentinel', __DIR__.'/../views');

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