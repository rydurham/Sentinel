<?php

namespace Sentinel;

use Artisan;
use Hashids\Hashids;
use ReflectionClass;
use Sentinel\Commands\SentinelPublishCommand;
use Sentinel\Repositories\Session\SentrySessionRepository;
use Sentinel\Repositories\Group\SentryGroupRepository;
use Sentinel\Repositories\User\SentryUserRepository;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class SentinelServiceProvider extends ServiceProvider
{
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
        $sentinelFilename = with(new ReflectionClass('Sentinel\SentinelServiceProvider'))->getFileName();
        $sentinelPath     = dirname($sentinelFilename);

        // Register Artisan Commands
        $this->registerArtisanCommands();

        // Establish Fallback Config settings
        $this->mergeConfigFrom($sentinelPath.'/../config/sentinel.php', 'sentinel');
        $this->mergeConfigFrom($sentinelPath.'/../config/sentry.php', 'sentry');

        // Establish Views Namespace
        if (is_dir(base_path() . '/resources/views/sentinel')) {
            // The package views have been published - use those views.
            $this->loadViewsFrom(base_path() . '/resources/views/sentinel', 'Sentinel');
        } else {
            // The package views have not been published. Use the defaults.
            $this->loadViewsFrom($sentinelPath . '/../views/bootstrap', 'Sentinel');
        }

        // Establish Translator Namespace
        $this->loadTranslationsFrom($sentinelPath . '/../lang', 'Sentinel');

        // Include custom validation rules
        include $sentinelPath . '/../validators.php';

        // Should we register the default routes?
        if (config('sentinel.routes_enabled')) {
            include $sentinelPath . '/../routes.php';
        }

        // Set up event listeners
        $dispatcher = $this->app->make('events');
        $dispatcher->subscribe('Sentinel\Listeners\UserEventListener');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register the Sentry Service Provider
        $this->app->register('Sentinel\SentryServiceProvider');

       // Register the Vinkla/Hashids Service Provider
        $this->app->register('Vinkla\Hashids\HashidsServiceProvider');

        // Load the Sentry and Hashid Facade Aliases
        $loader = AliasLoader::getInstance();
        $loader->alias('Sentry', 'Cartalyst\Sentry\Facades\Laravel\Sentry');
        $loader->alias('Hashids', 'Vinkla\Hashids\Facades\Hashids');


        // Bind the User Repository
        $this->app->bind('Sentinel\Repositories\User\SentinelUserRepositoryInterface', function ($app) {
            return new SentryUserRepository(
                $app['sentry'],
                $app['config'],
                $app['events']
            );
        });

        // Bind the Group Repository
        $this->app->bind('Sentinel\Repositories\Group\SentinelGroupRepositoryInterface', function ($app) {
            return new SentryGroupRepository(
                $app['sentry'],
                $app['events']
            );
        });

        // Bind the Session Manager
        $this->app->bind('Sentinel\Repositories\Session\SentinelSessionRepositoryInterface', function ($app) {
            return new SentrySessionRepository(
                $app['sentry'],
                $app['events']
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
        return array('auth', 'sentry');
    }

    /**
     * Register the Artisan Commands
     */
    private function registerArtisanCommands()
    {
        $this->app->singleton('sentinel.publisher', function ($app) {
            return new SentinelPublishCommand(
                $app->make('files')
            );
        });

        $this->commands('sentinel.publisher');
    }
}
