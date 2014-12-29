<?php namespace Sentinel\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider {

    /**
     * Register the Handler Bindings
     *
     * @return  void
     */
    public function register()
    {

    }

    /*
     * Register Listeners prior to application route handling
     */
    public function boot()
    {
        $dispatcher = $this->app->make('events');

        // Set up event listeners
        $dispatcher->subscribe('Sentinel\Handlers\UserEventHandler');

        // Set up mailer listener
        $dispatcher->subscribe('Sentinel\Mailers\UserMailer');

    }

}