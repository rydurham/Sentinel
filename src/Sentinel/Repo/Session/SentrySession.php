<?php namespace Sentinel\Repo\Session;

use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Sentinel\Repo\RepoAbstract;
use Config;

class SentrySession extends RepoAbstract implements SessionInterface {

	protected $sentry;
	protected $throttleProvider;


	public function __construct(Sentry $sentry)
	{
		$this->sentry = $sentry;

		// Get the Throttle Provider
		$this->throttleProvider = $this->sentry->getThrottleProvider();

		// Enable the Throttling Feature
		$this->throttleProvider->enable();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($data)
	{
		$result = array();
		try
			{
			    // Check for 'rememberMe' in POST data
			    if (!array_key_exists('rememberMe', $data)) $data['rememberMe'] = 0;

			    // Get the user provider
			    $userProvider = $this->sentry->getUserProvider();

			    // Set login credentials
			    $credentials['password'] = e($data['password']);
			    
			    if (Config::has('Sentinel::config.allow_usernames') && Config::get('Sentinel::config.allow_usernames') )
			    {

			    	if ($this->validEmail( e( $data['email']) ) )
				    {
				    	$credentials['email'] = e( $data['email']);
				    }
				    else 
				    {
				    	// Tell sentry to check usernames
				    	$userProvider->getEmptyUser()->setLoginAttributeName('username');

				    	// Set the username credential
				    	$credentials['username'] = e( $data['email'] );
				    }
			    }
			    else 
			    {
			    	$credentials['email'] = e( $data['email'] );
			    }

			    //Check for suspension or banned status
				$user = $userProvider->findByCredentials($credentials);
				$throttle = $this->throttleProvider->findByUserId($user->id);
			    $throttle->check();

			    // Try to authenticate the user
			    $user = $this->sentry->authenticate($credentials, e($data['rememberMe']));

			    $result['success'] = true;
			    $result['user'] = $user;

			    // Might be unnecessary, but just in case: 
			    $userProvider->getEmptyUser()->setLoginAttributeName('email');
			}
            catch (WrongPasswordException $e)
            {
                $this->recordLoginAttempt($credentials);
                $result['success'] = false;
                $result['message'] = trans('Sentinel::sessions.invalid');
            }
			catch (UserNotFoundException $e)
			{
			    // Sometimes a user is found, however hashed credentials do
			    // not match. Therefore a user technically doesn't exist
			    // by those credentials. Check the error message returned
			    // for more information.
			    $result['success'] = false;
			    $result['message'] = trans('Sentinel::sessions.invalid');
			}
			catch (UserNotActivatedException $e)
			{
			    $result['success'] = false;
			    $url = route('Sentinel\resendActivationForm');
			    $result['message'] = trans('Sentinel::sessions.notactive', array('url' => $url));
			}

			// The following is only required if throttle is enabled
			catch (UserSuspendedException $e)
			{
                $this->recordLoginAttempt($credentials);
                $time = $throttle->getSuspensionTime();
			    $result['success'] = false;
			    $result['message'] = trans('Sentinel::sessions.suspended');
			}
			catch (UserBannedException $e)
			{
                $this->recordLoginAttempt($credentials);
                $result['success'] = false;
			    $result['message'] = trans('Sentinel::sessions.banned');
			}

			//Login was succesful.  
			return $result;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		$this->sentry->logout();
	}

    /**
     * Record a login attempt to the throttle table.  This only works if the login attempt was
     * made against a valid user object.
     *
     * @param $credentials
     */
    private function recordLoginAttempt($credentials)
    {
        if (array_key_exists('email', $credentials))
        {
            $throttle = $this->sentry->findThrottlerByUserLogin(
                $credentials['email'],
                \Request::ip()
            );
        }

        if (array_key_exists('username', $credentials))
        {
	        $this->sentry->getUserProvider()->getEmptyUser()->setLoginAttributeName('username');
	        $throttle = $this->sentry->findThrottlerByUserLogin(
                $credentials['username'],
                \Request::ip()
            );
        }

        if (isset($throttle))
        {
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
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
		    return false;
		}

		return true;
	}


}