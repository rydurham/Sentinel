<?php namespace Sentinel\Repo;

use Illuminate\Support\ServiceProvider;
use Sentinel\Repo\Session\SentrySession;
use Sentinel\Repo\User\SentryUser;
use Sentinel\Repo\Group\SentryGroup;
use Cartalyst\Sentry\Sentry;

class RepoServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 */
	public function register()
	{
		$app = $this->app;

		 // Bind the Session Repository
        $app->bind('Sentinel\Repo\Session\SessionInterface', function($app)
        {
            return new SentrySession(
            	$app['sentry']
            );
        });

        // Bind the User Repository
        $app->bind('Sentinel\Repo\User\UserInterface', function($app)
        {
            return new SentryUser(
            	$app['sentry']
            );
        });

        // Bind the Group Repository
        $app->bind('Sentinel\Repo\Group\GroupInterface', function($app)
        {
            return new SentryGroup(
                $app['sentry']
            );
        });
	}

}