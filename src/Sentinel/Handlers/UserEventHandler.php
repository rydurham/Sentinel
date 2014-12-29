<?php namespace Sentinel\Handlers;

use Illuminate\Session\Store;

class UserEventHandler {

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin($user)
    {
        $this->session->put('userId', $user->id);
        $this->session->put('email', $user->email);
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout()
    {
        $this->session->flush();
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen('sentinel.user.login', 'Sentinel\Handlers\UserEventHandler@onUserLogin', 10);
        $events->listen('sentinel.user.logout', 'Sentinel\Handlers\UserEventHandler@onUserLogout', 10);
    }
}