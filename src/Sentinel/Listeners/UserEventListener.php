<?php

namespace Sentinel\Listeners;

use Sentinel\Mail\PasswordReset;
use Sentinel\Mail\Welcome;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Config\Repository;

class UserEventListener
{
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen('sentinel.user.login', 'Sentinel\Listeners\UserEventListener@onUserLogin', 10);
        $events->listen('sentinel.user.logout', 'Sentinel\Listeners\UserEventListener@onUserLogout', 10);
        $events->listen('sentinel.user.registered', 'Sentinel\Listeners\UserEventListener@welcome', 10);
        $events->listen('sentinel.user.resend', 'Sentinel\Listeners\UserEventListener@welcome', 10);
        $events->listen('sentinel.user.reset', 'Sentinel\Listeners\UserEventListener@passwordReset', 10);
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin($user)
    {
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout()
    {
    }

    /**
     * Send a welcome email to a new user.
     *
     * @param $user
     * @param $activated
     *
     * @return bool
     * @internal param string $email
     * @internal param int $userId
     * @internal param string $activationCode
     */
    public function welcome($user, $activated)
    {
        // We only want to send this message if the account
        // has not been activated
        if (! $activated) {

            Mail::to($user->email)->send(
                new Welcome(
                    $user->email,
                    $user->hash,
                    $user->getActivationCode()
                )
            );
        }
    }

    /**
     * Email Password Reset info to a user.
     *
     * @param $user
     * @param $code
     *
     * @internal param string $email
     * @internal param int $userId
     * @internal param string $resetCode
     */
    public function passwordReset($user, $code)
    {
        Mail::to($user->email)->send(
            new PasswordReset(
                $user->email,
                $user->hash,
                $code
            )
        );
    }

}
