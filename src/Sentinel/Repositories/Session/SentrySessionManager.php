<?php namespace Sentinel\Repositories\Session;

use Config;
use Illuminate\Events\Dispatcher;
use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Sentinel\Services\Responders\BaseResponse;
use Sentinel\Services\Responders\SuccessResponse;
use Sentinel\Services\Responders\FailureResponse;

class SentrySessionManager implements SentinelSessionManagerInterface {

    protected $sentry;
    protected $throttleProvider;
    protected $userProvider;
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(Sentry $sentry, Dispatcher $dispatcher)
    {
        // Sentry Singleton Object
        $this->sentry = $sentry;
        $this->dispatcher = $dispatcher;

        // Get the Throttle Provider
        $this->throttleProvider = $this->sentry->getThrottleProvider();

        // Enable the Throttling Feature
        $this->throttleProvider->enable();

        // Get the user provider
        $this->userProvider = $this->sentry->getUserProvider();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return BaseResponse
     */
    public function store($data)
    {
        // Check for 'rememberMe' in POST data
        $rememberMe = isset($data['rememberMe']);

        // Set login credentials
        $credentials['password'] = e($data['password']);
        $credentials['email']    = isset($data['email']) ? e($data['email']) : '';

        // Should we check for a username?
        if (Config::get('Sentinel::auth.allow_usernames', false) && isset($data['username']))
        {
            $credentials['username'] =  e($data['username']);
        }

        // If the email address is blank or not valid, try using the username as the primary login credential
        if ( ! $this->validEmail($credentials['email']))
        {
            $this->userProvider->getEmptyUser()->setLoginAttributeName('username');
        }

        //Check for suspension or banned status
        $user     = $this->userProvider->findByCredentials($credentials);
        $throttle = $this->throttleProvider->findByUserId($user->id);
        $throttle->check();

        // Try to authenticate the user
        $user = $this->sentry->authenticate($credentials, $rememberMe);

        // Might be unnecessary, but just in case:
        $this->userProvider->getEmptyUser()->setLoginAttributeName('email');

        // Login was successful. Fire the Sentinel.user.login event
        $this->dispatcher->fire('sentinel.user.login', ['user' => $user]);

        // Return Response Object
        return new SuccessResponse('');

    }

    /**
     * Log the current user out and destroy their session
     *
     * @param  int $id
     *
     * @return BaseResponse
     */
    public function destroy()
    {
        // Fire the Sentinel User Logout event
        $user = $this->sentry->getUser();
        $this->dispatcher->fire('sentinel.user.logout', ['user' => $user]);

        // Destroy the user's session and log them out
        $this->sentry->logout();

        return new SuccessResponse('');

    }

    /**
     * Validate an email address
     * http://stackoverflow.com/questions/12026842/how-to-validate-an-email-address-in-php
     */
    private function validEmail($email)
    {
        if ( ! filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }

        return true;
    }


}