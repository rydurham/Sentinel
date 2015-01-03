<?php namespace Sentinel\Repositories\User;

use Cartalyst\Sentry\Sentry;
use Illuminate\Auth\UserInterface;
use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;
use Illuminate\Auth\UserProviderInterface;
use Illuminate\Http\Response;
use Sentinel\Services\Responders\FailureResponse;
use Sentinel\Services\Responders\SuccessResponse;

class SentryUserRepository implements SentinelUserRepositoryInterface, UserProviderInterface
{
    protected $sentry;
    protected $config;
    protected $dispatcher;

    /**
     * Construct a new SentryUser Object
     */
    public function __construct(Sentry $sentry, Repository $config, Dispatcher $dispatcher)
    {
        $this->sentry     = $sentry;
        $this->config     = $config;
        $this->dispatcher = $dispatcher;

        // Get the Throttle Provider
        $this->throttleProvider = $this->sentry->getThrottleProvider();

        // Enable the Throttling Feature
        $this->throttleProvider->enable();
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store($data)
    {
        // Should we automatically activate this user?
        if (array_key_exists('activate', $data)) {
            $activateUser = (bool)$data['activate'];
        } else {
            $activateUser = ! $this->config->get('Sentinel::auth.require_activation', true);
        }

        //Prepare the user credentials
        $credentials = [
            'email'    => e($data['email']),
            'password' => e($data['password'])
        ];

        // Are we allowed to use usernames?
        if ($this->config->has('Sentinel::auth.allow_usernames', false)) {
            // Make sure a username was provided with the user data
            if (array_key_exists('username', $data)) {
                $credentials['username'] = e($data['username']);
            }
        }

        // Attempt user registration
        $user = $this->sentry->register($credentials, $activateUser, $data);

        // If the developer has specified additional fields for this user, update them here.
        foreach ($this->config->get('Sentinel::auth.additional_user_fields', []) as $key => $value) {
            if (array_key_exists($key, $data)) {
                $user->$key = e($data[$key]);
            }
        }
        $user->save();

        // If no group memberships were specified, use the default groups from config
        if (array_key_exists('groups', $data)) {
            $groups = $data['groups'];
        } else {
            $groups = $this->config->get('Sentinel::auth.default_user_groups', []);
        }

        // Assign groups to this user
        foreach ($groups as $name) {
            $group = $this->sentry->getGroupProvider()->findByName($name);
            $user->addGroup($group);
        }

        // User registration was successful.  Determine response message
        if ($activateUser) {
            $message = trans('Sentinel::users.createdactive');
        } else {
            $message = trans('Sentinel::users.created');
        }

        // Response Payload
        $payload = [
            'user'      => $user,
            'activated' => $activateUser
        ];

        // Fire the 'user registered' event
        $this->dispatcher->fire('sentinel.user.registered', $payload);

        // Return a response
        return new SuccessResponse($message, $payload);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     *
     * @return Response
     */
    public function update($data)
    {
        // Find the user using the user id
        $user = $this->sentry->findUserById($data['id']);

        // Update User Details
        $user->email    = (isset($data['email']) ? e($data['email']) : $user->email);
        $user->username = (isset($data['username']) ? e($data['username']) : $user->username);

        // Are there additional fields specified in the confi? If so, update them here.
        foreach ($this->config->get('Sentinel::auth.additional_user_fields', []) as $key => $value) {
            $user->$key = (isset($data[$key]) ? e($data[$key]) : $user->$key);
        }

        // Update the user
        if ($user->save()) {
            // User information was updated
            $this->dispatcher->fire('sentinel.user.updated', ['user' => $user]);

            return new SuccessResponse(trans('Sentinel::users.updated'), ['user' => $user]);
        }

        return new FailureResponse(trans('Sentinel::users.notupdated'), ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        // Find the user using the user id
        $user = $this->sentry->findUserById($id);

        // Delete the user
        if ($user->delete()) {
            //Fire the sentinel.user.destroyed event
            $this->dispatcher->fire('sentinel.user.destroyed', ['user' => $user]);

            return new SuccessResponse(trans('Sentinel::users.destroyed'), ['user' => $user]);
        }

        // Unable to delete the user
        return new FailureResponse(trans('Sentinel::users.notdestroyed'), ['user' => $user]);
    }

    /**
     * Attempt activation for the specified user
     *
     * @param  int    $id
     * @param  string $code
     *
     * @return bool
     */
    public function activate($id, $code)
    {
        // Find the user using the user id
        $user = $this->sentry->findUserById($id);

        // Attempt to activate the user
        if ($user->attemptActivation($code)) {
            // User activation passed
            $this->dispatcher->fire('sentinel.user.activated', ['user' => $user]);

            // Generate login url
            $url = route('sentinel.login');

            return new SuccessResponse(trans('Sentinel::users.activated', array('url' => $url)), ['user' => $user]);
        }

        return new FailureResponse(trans('Sentinel::users.notactivated'), ['user' => $user]);
    }

    /**
     * Resend the activation email to the specified email address
     *
     * @param  Array $data
     *
     * @return Response
     */
    public function resend($data)
    {
        //Attempt to find the user.
        $user = $this->sentry->getUserProvider()->findByLogin(e($data['email']));

        // If the user is not currently activated resend the activation email
        if ( ! $user->isActivated()) {

            $this->dispatcher->fire('sentinel.user.resend', [
                'user'      => $user,
                'activated' => $user->activated,
            ]);

            return new SuccessResponse(trans('Sentinel::users.emailconfirm'), ['user' => $user]);
        }

        // The user is already activated
        return new FailureResponse(trans('Sentinel::users.alreadyactive'), ['user' => $user]);
    }

    /**
     * Handle a password reset rewuest
     *
     * @param  Array $data
     *
     * @return Bool
     */
    public function forgotPassword($data)
    {
        $user = $this->sentry->getUserProvider()->findByLogin(e($data['email']));

        $this->dispatcher->fire('sentinel.user.forgot', [
            'user'      => $user,
            'resetCode' => $user->getResetPasswordCode()
        ]);

        return new SuccessResponse(trans('Sentinel::users.emailinfo'), ['user' => $user]);
    }


    /**
     * Process the password reset request
     *
     * @param  int    $id
     * @param  string $code
     *
     * @return Array
     */
    public function resetPassword($id, $code)
    {
        // Find the user
        $user        = $this->sentry->getUserProvider()->findById($id);
        $newPassword = $this->_generatePassword(8, 8);

        // Attempt to reset the user password
        if ($user->attemptResetPassword($code, $newPassword)) {
            // Email the reset code to the user
            $this->dispatcher->fire('sentinel.user.newpassword', array(
                'user'        => $user,
                'newPassword' => $newPassword
            ));

            $result['success'] = true;
            $result['message'] = trans('Sentinel::users.emailpassword');
        } else {
            // Password reset failed
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.problem');
        }
    }

    /**
     * Process a change password request.
     * @return Array $data
     */
    public function changePassword($data)
    {
        $user = $this->sentry->getUserProvider()->findById($data['id']);

        if ($user->checkHash(e($data['oldPassword']), $user->getPassword())) {

            //The oldPassword matches the current password in the DB. Proceed.
            $user->password = e($data['newPassword']);

            if ($user->save()) {
                // User saved
                $this->dispatcher->fire('sentinel.user.passwordchange', ['user' => $user]);

                return new SuccessResponse(trans('Sentinel::users.passwordchg'), ['user' => $user]);

            }

            // User not Saved
            return new FailureResponse(trans('Sentinel::users.passwordprob'), ['user' => $user]);
        }

        // Password mismatch. Abort.
        return new FailureResponse(trans('Sentinel::users.oldpassword'), ['user' => $user]);
    }

    /**
     * Suspend a user
     *
     * @param  int $id
     * @param  int $minutes
     *
     * @return Array
     */
    public function suspend($id)
    {
        // Find the user using the user id
        $throttle = $this->sentry->findThrottlerByUserId($id);

        // Suspend the user
        $throttle->suspend();

        // Fire the 'user suspended' event
        $this->dispatcher->fire('sentinel.user.suspended', ['userId' => $id]);

        return new SuccessResponse(trans('Sentinel::users.suspended'), ['userId' => $id]);
    }

    /**
     * Remove a users' suspension.
     *
     * @param $id
     *
     * @return array [type]     [description]
     * @internal param $ [type] $id [description]
     *
     */
    public function unSuspend($id)
    {
        // Find the user using the user id
        $throttle = $this->sentry->findThrottlerByUserId($id);

        // Un-suspend the user
        $throttle->unsuspend();

        // Fire the 'user un-suspended' event
        $this->dispatcher->fire('sentinel.user.unsuspended', ['userId' => $id]);

        return new SuccessResponse(trans('Sentinel::users.unsuspended'), ['userId' => $id]);
    }

    /**
     * Ban a user
     *
     * @param  int $id
     *
     * @return Array
     */
    public function ban($id)
    {
        // Find the user using the user id
        $throttle = $this->sentry->findThrottlerByUserId($id);

        // Ban the user
        $throttle->ban();

        // Fire the 'banned user' event
        $this->dispatcher->fire('sentinel.user.banned', ['userId' => $id]);

        return new SuccessResponse(trans('Sentinel::users.banned'), ['userId' => $id]);
    }

    /**
     * Remove a users' ban
     *
     * @param  int $id
     *
     * @return Array
     */
    public function unBan($id)
    {
        // Find the user using the user id
        $throttle = $this->sentry->findThrottlerByUserId($id);

        // Un-ban the user
        $throttle->unBan();

        // Fire the 'un-ban user event'
        $this->dispatcher->fire('sentinel.user.unbanned', ['userId' => $id]);

        return new SuccessResponse(trans('Sentinel::users.unbanned'), ['userId' => $id]);
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     *
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveById($identifier)
    {
        $model = $this->sentry->getUserProvider()->createModel();

        return $model->find($identifier);
    }

    /**
     * Retrieve a user by by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string $token
     *
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $model = $this->sentry->getUserProvider()->createModel();

        return $model->where('id', $identifier)->where('persist_code', $token)->first();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Auth\UserInterface $user
     * @param  string                         $token
     *
     * @return void
     */
    public function updateRememberToken(UserInterface $user, $token)
    {
        $model = $this->sentry->getUserProvider()->createModel();

        $model->where('id', $user->id)->update('persist_code', $token);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     *
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return $this->sentry->findUserByCredentials($credentials);
    }


    /**
     * Return all the registered users
     *
     * @return stdObject Collection of users
     */
    public function all()
    {
        $users = $this->sentry->findAllUsers();

        foreach ($users as $user) {
            if ($user->isActivated()) {
                $user->status = "Active";
            } else {
                $user->status = "Not Active";
            }

            //Pull Suspension & Ban info for this user
            $throttle = $this->throttleProvider->findByUserId($user->id);

            //Check for suspension
            if ($throttle->isSuspended()) {
                // User is Suspended
                $user->status = "Suspended";
            }

            //Check for ban
            if ($throttle->isBanned()) {
                // User is Banned
                $user->status = "Banned";
            }
        }

        return $users;
    }

    /**
     * Return the current active user
     *
     * @return user object
     */
    public function getUser()
    {
        return $this->sentry->getUser();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Auth\UserInterface $user
     * @param  array                          $credentials
     *
     * @return bool
     */
    public function validateCredentials(UserInterface $user, array $credentials)
    {
        if (isset($credentials['email']) && $credentials['email'] != $user->email) {
            return false;
        }

        if (isset($credentials['username']) && $credentials['username'] != $user->username) {
            return false;
        }

        return $user->checkPassword($credentials['password']);
    }
}
