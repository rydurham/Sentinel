<?php namespace Sentinel;

use Sentinel\Managers\Session\SentrySessionManager;
use Sentinel\Providers\EventServiceProvider;
use Sentinel\Providers\RepositoryServiceProvider;
use Sentinel\Providers\ValidationServiceProvider;
use Illuminate\Support\ServiceProvider;
use Sentinel\Repositories\Group\SentryGroupRepository;
use Sentinel\Repositories\User\SentryUserRepository;

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
        // Find path to the package
        $sentinelFilename = with(new \ReflectionClass('\Sentinel\SentinelServiceProvider'))->getFileName();
        $sentinelPath = dirname($sentinelFilename);

        // Load the package
        $this->package('rydurham/sentinel');

        // Register the Sentry Service Provider
        $this->app->register('Sentinel\Providers\SentryServiceProvider');

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
        include $sentinelPath . '/../filters.php';
        include $sentinelPath . '/../validators.php';

        // Should we load the default routes?
        if ($this->app['config']['Sentinel::routing.routes_enabled'])
        {
            include $sentinelPath . '/../routes.php';
        }

        // Boot the Event Service Provider
        $events = new EventServiceProvider($this->app);
        $events->boot();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Load the Sentry Facade Alias
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Sentry', 'Cartalyst\Sentry\Facades\Laravel\Sentry');

        // Register Validation Handling
        $validation = new ValidationServiceProvider($this->app);
        $validation->register();

        // Bind the User Repository
        $this->app->bind('Sentinel\Repositories\User\SentinelUserRepositoryInterface', function($app)
        {
            return new SentryUserRepository(
                $app['sentry'],
                $app['config'],
                $app['events']
            );
        });

        // Bind the Group Repository
        $this->app->bind('Sentinel\Repositories\Group\SentinelGroupRepositoryInterface', function($app)
        {
            return new SentryGroupRepository(
                $app['sentry'],
                $app['events']
            );
        });

        // Bind the Session Manager
        $this->app->bind('Sentinel\Managers\Session\SentinelSessionManagerInterface', function($app)
        {
            return new SentrySessionManager(
                $app['sentry'],
                $app->make('events')
            );
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
