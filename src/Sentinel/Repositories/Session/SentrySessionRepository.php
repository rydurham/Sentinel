<?php

namespace Sentinel\Repositories\Session;

use Config;
use Illuminate\Events\Dispatcher;
use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Sentinel\DataTransferObjects\BaseResponse;
use Sentinel\DataTransferObjects\ExceptionResponse;
use Sentinel\DataTransferObjects\SuccessResponse;
use Sentinel\DataTransferObjects\FailureResponse;

class SentrySessionRepository implements SentinelSessionRepositoryInterface
{
    private $sentry;
    private $sentryThrottleProvider;
    private $sentryUserProvider;
    private $dispatcher;

    public function __construct(Sentry $sentry, Dispatcher $dispatcher)
    {
        // Sentry Singleton Object
        $this->sentry     = $sentry;
        $this->dispatcher = $dispatcher;

        // Get the Throttle Provider
        $this->sentryThrottleProvider = $this->sentry->getThrottleProvider();

        // Enable the Throttling Feature
        $this->sentryThrottleProvider->enable();

        // Get the user provider
        $this->sentryUserProvider = $this->sentry->getUserProvider();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return BaseResponse
     */
    public function store($data)
    {
        try {
            // Check for 'rememberMe' in POST data
            $rememberMe = isset($data['rememberMe']);

            // Set login credentials
            $credentials['password'] = e($data['password']);
            $credentials['email']    = isset($data['email']) ? e($data['email']) : '';

            // Should we check for a username?
            if (Config::get('Sentinel::auth.allow_usernames', false) && isset($data['username'])) {
                $credentials['username'] = e($data['username']);
            }

            // If the email address is blank or not valid, try using the username as the primary login credential
            if (!$this->validEmail($credentials['email'])) {
                // Tell sentry to look for a username when attempting login
                $this->sentryUserProvider->getEmptyUser()->setLoginAttributeName('username');

                // Remove the email credential
                unset($credentials['email']);

                // Set the 'username' credential
                $credentials['username'] = (isset($credentials['username']) ? $credentials['username'] : e($data['email']));
            }

            //Check for suspension or banned status
            $user     = $this->sentryUserProvider->findByCredentials($credentials);
            $throttle = $this->sentryThrottleProvider->findByUserId($user->id);
            $throttle->check();

            // Try to authenticate the user
            $user = $this->sentry->authenticate($credentials, $rememberMe);

            // Might be unnecessary, but just in case:
            $this->sentryUserProvider->getEmptyUser()->setLoginAttributeName('email');

            // Login was successful. Fire the Sentinel.user.login event
            $this->dispatcher->fire('sentinel.user.login', ['user' => $user]);

            // Return Response Object
            return new SuccessResponse('');
        } catch (WrongPasswordException $e) {
            $message = trans('Sentinel::sessions.invalid');
            $this->recordLoginAttempt($credentials);
            return new ExceptionResponse($message);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');
            return new ExceptionResponse($message);
        } catch (UserNotActivatedException $e) {
            $url = route('sentinel.reactivate.form');
            $this->recordLoginAttempt($credentials);
            $message = trans('Sentinel::sessions.notactive', array('url' => $url));
            return new ExceptionResponse($message);
        } catch (UserSuspendedException $e) {
            $message = trans('Sentinel::sessions.suspended');
            $this->recordLoginAttempt($credentials);
            return new ExceptionResponse($message);
        } catch (UserBannedException $e) {
            $message = trans('Sentinel::sessions.banned');
            $this->recordLoginAttempt($credentials);
            return new ExceptionResponse($message);
        }
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
     * Record a login attempt to the throttle table.  This only works if the login attempt was
     * made against a valid user object.
     *
     * @param $credentials
     */
    private function recordLoginAttempt($credentials)
    {
        if (array_key_exists('email', $credentials)) {
            $throttle = $this->sentry->findThrottlerByUserLogin(
                $credentials['email'],
                \Request::ip()
            );
        }

        if (array_key_exists('username', $credentials)) {
            $this->sentryUserProvider->getEmptyUser()->setLoginAttributeName('username');
            $throttle = $this->sentry->findThrottlerByUserLogin(
                $credentials['username'],
                \Request::ip()
            );
        }

        if (isset($throttle)) {
            $throttle->ip_address = \Request::ip();

            $throttle->addLoginAttempt();
        }
    }

    /**
     * Validate an email address
     * http://stackoverflow.com/questions/12026842/how-to-validate-an-email-address-in-php
     */
    private function validEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}
