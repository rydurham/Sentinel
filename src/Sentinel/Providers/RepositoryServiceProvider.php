<?php namespace Sentinel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use Sentinel\Repositories\Session\SentrySession;
use Sentinel\Repositories\User\SentryUserManager;
use Sentinel\Repositories\Group\SentryGroupManager;
use Cartalyst\Sentry\Sentry;

class RepositoryServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 */
	public function register()
	{
		$app = $this->app;

		 // Bind the Session Repository
        $app->bind('Sentinel\Repositories\Session\SessionInterface', function($app)
        {
            return new SentrySession(
            	$app['sentry']
            );
        });

        // Bind the User Repository
        $app->bind('Sentinel\Repositories\User\SentinelUserManagerInterface', function($app)
        {
            return new SentryUserManager(
            	$app['sentry'],
                $app['config'],
                $app['events']
            );
        });

        // Bind the Group Repository
        $app->bind('Sentinel\Repositories\Group\SentinelGroupManagerInterface', function($app)
        {
            return new SentryGroupManager(
                $app['sentry']
            );
        });
	}

}