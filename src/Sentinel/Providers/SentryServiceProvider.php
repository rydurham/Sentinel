<?php namespace Sentinel\Providers;
/**
 * Modified from the Original Sentry Service Provider. This version pulls
 * config data from the Sentinel "Sentry" config file, rather than the
 * default Sentry config file. It also adds default exception handling.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Sentry\Cookies\IlluminateCookie;
use Cartalyst\Sentry\Groups\Eloquent\Provider as GroupProvider;
use Cartalyst\Sentry\Groups\GroupExistsException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Groups\NameRequiredException;
use Cartalyst\Sentry\Hashing\BcryptHasher;
use Cartalyst\Sentry\Hashing\NativeHasher;
use Cartalyst\Sentry\Hashing\Sha256Hasher;
use Cartalyst\Sentry\Hashing\WhirlpoolHasher;
use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Sessions\IlluminateSession;
use Cartalyst\Sentry\Throttling\Eloquent\Provider as ThrottleProvider;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Users\Eloquent\Provider as UserProvider;
use Cartalyst\Sentry\Users\UserAlreadyActivatedException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Illuminate\Support\ServiceProvider;
use Sentinel\Services\Responders\FailureResponse;

class SentryServiceProvider extends ServiceProvider {

    public function __construct($app)
    {
        parent::__construct($app);
        $this->redirect = $this->app->make('redirect');
        $this->session  = $this->app->make('session');
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('cartalyst/sentry', 'cartalyst/sentry');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHasher();
        $this->registerUserProvider();
        $this->registerGroupProvider();
        $this->registerThrottleProvider();
        $this->registerSession();
        $this->registerCookie();
        $this->registerSentry();
        $this->registerExceptions();
    }

    /**
     * Register the hasher used by Sentry.
     *
     * @return void
     */
    protected function registerHasher()
    {
        $this->app['sentry.hasher'] = $this->app->share(function($app)
        {
            $hasher = $app['config']['Sentinel::sentry.hasher'];

            switch ($hasher)
            {
                case 'native':
                    return new NativeHasher;
                    break;

                case 'bcrypt':
                    return new BcryptHasher;
                    break;

                case 'sha256':
                    return new Sha256Hasher;
                    break;

                case 'whirlpool':
                    return new WhirlpoolHasher;
                    break;
            }

            throw new \InvalidArgumentException("Invalid hasher [$hasher] chosen for Sentry.");
        });
    }

    /**
     * Register the user provider used by Sentry.
     *
     * @return void
     */
    protected function registerUserProvider()
    {
        $this->app['sentry.user'] = $this->app->share(function($app)
        {
            $model = $app['config']['Sentinel::sentry.users.model'];

            // We will never be accessing a user in Sentry without accessing
            // the user provider first. So, we can lazily set up our user
            // model's login attribute here. If you are manually using the
            // attribute outside of Sentry, you will need to ensure you are
            // overriding at runtime.
            if (method_exists($model, 'setLoginAttributeName'))
            {
                $loginAttribute = $app['config']['Sentinel::sentry.users.login_attribute'];

                forward_static_call_array(
                    array($model, 'setLoginAttributeName'),
                    array($loginAttribute)
                );
            }

            // Define the Group model to use for relationships.
            if (method_exists($model, 'setGroupModel'))
            {
                $groupModel = $app['config']['Sentinel::sentry.groups.model'];

                forward_static_call_array(
                    array($model, 'setGroupModel'),
                    array($groupModel)
                );
            }

            // Define the user group pivot table name to use for relationships.
            if (method_exists($model, 'setUserGroupsPivot'))
            {
                $pivotTable = $app['config']['Sentinel::sentry.user_groups_pivot_table'];

                forward_static_call_array(
                    array($model, 'setUserGroupsPivot'),
                    array($pivotTable)
                );
            }

            return new UserProvider($app['sentry.hasher'], $model);
        });
    }

    /**
     * Register the group provider used by Sentry.
     *
     * @return void
     */
    protected function registerGroupProvider()
    {
        $this->app['sentry.group'] = $this->app->share(function($app)
        {
            $model = $app['config']['Sentinel::sentry.groups.model'];

            // Define the User model to use for relationships.
            if (method_exists($model, 'setUserModel'))
            {
                $userModel = $app['config']['Sentinel::sentry.users.model'];

                forward_static_call_array(
                    array($model, 'setUserModel'),
                    array($userModel)
                );
            }

            // Define the user group pivot table name to use for relationships.
            if (method_exists($model, 'setUserGroupsPivot'))
            {
                $pivotTable = $app['config']['Sentinel::sentry.user_groups_pivot_table'];

                forward_static_call_array(
                    array($model, 'setUserGroupsPivot'),
                    array($pivotTable)
                );
            }

            return new GroupProvider($model);
        });
    }

    /**
     * Register the throttle provider used by Sentry.
     *
     * @return void
     */
    protected function registerThrottleProvider()
    {
        $this->app['sentry.throttle'] = $this->app->share(function($app)
        {
            $model = $app['config']['Sentinel::sentry.throttling.model'];

            $throttleProvider = new ThrottleProvider($app['sentry.user'], $model);

            if ($app['config']['Sentinel::sentry.throttling.enabled'] === false)
            {
                $throttleProvider->disable();
            }

            if (method_exists($model, 'setAttemptLimit'))
            {
                $attemptLimit = $app['config']['Sentinel::sentry.throttling.attempt_limit'];

                forward_static_call_array(
                    array($model, 'setAttemptLimit'),
                    array($attemptLimit)
                );
            }
            if (method_exists($model, 'setSuspensionTime'))
            {
                $suspensionTime = $app['config']['Sentinel::sentry.throttling.suspension_time'];

                forward_static_call_array(
                    array($model, 'setSuspensionTime'),
                    array($suspensionTime)
                );
            }

            // Define the User model to use for relationships.
            if (method_exists($model, 'setUserModel'))
            {
                $userModel = $app['config']['Sentinel::sentry.users.model'];

                forward_static_call_array(
                    array($model, 'setUserModel'),
                    array($userModel)
                );
            }

            return $throttleProvider;
        });
    }

    /**
     * Register the session driver used by Sentry.
     *
     * @return void
     */
    protected function registerSession()
    {
        $this->app['sentry.session'] = $this->app->share(function($app)
        {
            $key = $app['config']['Sentinel::sentry.cookie.key'];

            return new IlluminateSession($app['session.store'], $key);
        });
    }

    /**
     * Register the cookie driver used by Sentry.
     *
     * @return void
     */
    protected function registerCookie()
    {
        $this->app['sentry.cookie'] = $this->app->share(function($app)
        {
            $key = $app['config']['Sentinel::sentry.cookie.key'];

            /**
             * We'll default to using the 'request' strategy, but switch to
             * 'jar' if the Laravel version in use is 4.0.*
             */

            $strategy = 'request';

            if (preg_match('/^4\.0\.\d*$/D', $app::VERSION))
            {
                $strategy = 'jar';
            }

            return new IlluminateCookie($app['request'], $app['cookie'], $key, $strategy);
        });
    }

    /**
     * Takes all the components of Sentry and glues them
     * together to create Sentry.
     *
     * @return void
     */
    protected function registerSentry()
    {
        $this->app['sentry'] = $this->app->share(function($app)
        {
            return new Sentry(
                $app['sentry.user'],
                $app['sentry.group'],
                $app['sentry.throttle'],
                $app['sentry.session'],
                $app['sentry.cookie'],
                $app['request']->getClientIp()
            );
        });
    }

    /**
     * Register Sentry Exception listeners
     */
    private function registerExceptions()
    {
        $this->app->error(function(UserNotFoundException $e)
        {
            // Sometimes a user is found, however hashed credentials do
            // not match. Therefore a user technically doesn't exist
            // by those credentials. Check the error message returned
            // for more information.
            $this->session->flash('error', trans('Sentinel::sessions.invalid'));

            // Make sure there is a URL we can go "back" to
            if ( ! $this->app['request']->header('referer'))
            {
                return $this->redirect->route('home');
            }

            return $this->redirect->back()->withInput();

        });

        $this->app->error(function(UserNotActivatedException $e)
        {
            // This user's account has not yet been activated
            $url     = route('sentinel.reactivate.form');
            $message = trans('Sentinel::sessions.notactive', array('url' => $url));

            $this->session->flash('error', $message);
            return $this->redirect->back()->withInput();

        });

        $this->app->error(function(UserAlreadyActivatedException $e)
        {
            // This user has tried to activate, but they are already activated
            $this->session->flash('error', trans('Sentinel::users.alreadyactive'));
            return $this->redirect->back()->withInput();

        });

        $this->app->error(function(UserSuspendedException $e)
        {
            // This user's account has been temporarily suspended
            $this->session->flash('error', trans('Sentinel::sessions.suspended'));
            return $this->redirect->back()->withInput();

        });

        $this->app->error(function(UserBannedException $e)
        {
            // This user has been banned.
            $this->session->flash('error', trans('Sentinel::sessions.banned'));
            return $this->redirect->back()->withInput();

        });

        $this->app->error(function(UserExistsException $e)
        {
            // There is already a user with those credentials
            $this->session->flash('error', trans('Sentinel::users.exists'));
            return $this->redirect->back()->withInput();
        });

        $this->app->error(function(NameRequiredException $e)
        {
            // You must provide a name for a group
            $this->session->flash('error', trans('Sentinel::groups.namereq'));
            return $this->redirect->back()->withInput();

        });

        $this->app->error(function(GroupExistsException $e)
        {
            // A group with this name already exists
            $this->session->flash('error', trans('Sentinel::groups.groupexists'));
            return $this->redirect->back()->withInput();
        });

        $this->app->error(function(GroupNotFoundException $e)
        {
            // Could not find the specified group in storage
            $this->session->flash('error', trans('Sentinel::groups.notfound'));
            return $this->redirect->back()->withInput();
        });
    }

}
