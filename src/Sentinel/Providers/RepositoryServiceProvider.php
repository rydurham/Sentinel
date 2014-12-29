<?php namespace Sentinel\Providers;

use Illuminate\Support\ServiceProvider;
use Sentinel\Repositories\Session\SentrySessionManager;
use Sentinel\Repositories\User\SentryUserManager;
use Sentinel\Repositories\Group\SentryGroupManager;

class RepositoryServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 */
	public function register()
	{
		$app = $this->app;

		 // Bind the Session Repository
        $app->bind('Sentinel\Repositories\Session\SentinelSessionManagerInterface', function($app)
        {
            return new SentrySessionManager(
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