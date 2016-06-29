<?php

namespace Sentinel\Repositories\User;

use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserAlreadyActivatedException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;
use Sentinel\Models\User;
use Sentinel\DataTransferObjects\BaseResponse;
use Sentinel\DataTransferObjects\SuccessResponse;
use Sentinel\DataTransferObjects\FailureResponse;
use Sentinel\DataTransferObjects\ExceptionResponse;

class SentryUserRepository implements SentinelUserRepositoryInterface, UserProvider
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
     * @return BaseResponse
     */
    public function store($data)
    {
        try {
            // Should we automatically activate this user?
            if (array_key_exists('activate', $data)) {
                $activateUser = (bool)$data['activate'];
            } else {
                $activateUser = !$this->config->get('sentinel.require_activation', true);
            }

            //Prepare the user credentials
            $credentials = [
                'email' => e($data['email']),
                'password' => e($data['password'])
            ];

            // Are we allowed to use usernames?
            if ($this->config->get('sentinel.allow_usernames', false)) {
                // Make sure a username was provided with the user data
                if (array_key_exists('username', $data)) {
                    $credentials['username'] = e($data['username']);
                }
            }

            // Attempt user registration
            $user = $this->sentry->register($credentials, $activateUser, $data);

            // If the developer has specified additional fields for this user, update them here.
            foreach ($this->config->get('sentinel.additional_user_fields', []) as $key => $value) {
                if (array_key_exists($key, $data)) {
                    $user->$key = e($data[$key]);
                }
            }
            $user->save();

            // If no group memberships were specified, use the default groups from config
            if (array_key_exists('groups', $data)) {
                $groups = $data['groups'];
            } else {
                $groups = $this->config->get('sentinel.default_user_groups', []);
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
                'user' => $user,
                'activated' => $activateUser
            ];

            // Fire the 'user registered' event
            $this->dispatcher->fire('sentinel.user.registered', $payload);

            // Return a response
            return new SuccessResponse($message, $payload);
        } catch (UserExistsException $e) {
            // If the User is already registered but hasn't yet completed the activation
            // process resend the activation email and show appropriate message.
            
            if ($this->config->get('sentinel.require_activation', true)) {

                //Attempt to find the user.
                $user = $this->sentry->getUserProvider()->findByLogin(e($data['email']));

                // If the user is not currently activated resend the activation email
                if (!$user->isActivated()) {
                    $this->dispatcher->fire('sentinel.user.resend', [
                        'user' => $user,
                        'activated' => $user->activated,
                    ]);

                    return new FailureResponse(trans('Sentinel::users.pendingactivation'), ['user' => $user]);
                }
            }

            $message = trans('Sentinel::users.exists');
            return new ExceptionResponse($message);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     *
     * @return BaseResponse
     */
    public function update($data)
    {
        try {
            // Find the user using the user id
            $user = $this->sentry->findUserById($data['id']);

            // Update User Details
            $user->email    = (isset($data['email']) ? e($data['email']) : $user->email);
            $user->username = (isset($data['username']) ? e($data['username']) : $user->username);

            // Are there additional fields specified in the config? If so, update them here.
            foreach ($this->config->get('sentinel.additional_user_fields', []) as $key => $value) {
                $user->$key = (isset($data[$key]) ? e($data[$key]) : $user->$key);
            }

            // Update the user
            if ($user->save()) {
                // User information was updated
                $this->dispatcher->fire('sentinel.user.updated', ['user' => $user]);

                return new SuccessResponse(trans('Sentinel::users.updated'), ['user' => $user]);
            }

            return new FailureResponse(trans('Sentinel::users.notupdated'), ['user' => $user]);
        } catch (UserExistsException $e) {
            $message = trans('Sentinel::users.exists');

            return new ExceptionResponse($message);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return BaseResponse
     */
    public function destroy($id)
    {
        try {
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
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
    }

    /**
     * Attempt activation for the specified user
     *
     * @param  int $id
     * @param  string $code
     *
     * @return bool
     */
    public function activate($id, $code)
    {
        try {
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
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        } catch (UserAlreadyActivatedException $e) {
            $message = trans('Sentinel::users.alreadyactive');

            return new ExceptionResponse($message);
        }
    }

    /**
     * Resend the activation email to the specified email address
     *
     * @param  Array $data
     *
     * @return BaseResponse
     */
    public function resend($data)
    {
        try {
            //Attempt to find the user.
            $user = $this->sentry->getUserProvider()->findByLogin(e($data['email']));

            // If the user is not currently activated resend the activation email
            if (!$user->isActivated()) {
                $this->dispatcher->fire('sentinel.user.resend', [
                    'user' => $user,
                    'activated' => $user->activated,
                ]);

                return new SuccessResponse(trans('Sentinel::users.emailconfirm'), ['user' => $user]);
            }

            // The user is already activated
            return new FailureResponse(trans('Sentinel::users.alreadyactive'), ['user' => $user]);
        } catch (UserNotFoundException $e) {
            // The user is trying to "reactivate" an account that doesn't exist.  This could be
            // a vector for determining valid existing accounts, so we will send a vague
            // response without actually sending a new activation email.
            $message = trans('Sentinel::users.pendingactivation');

            return new SuccessResponse($message, []);
        }
    }

    /**
     * The user has requested a password reset
     *
     * @param  Array $data
     *
     * @return Bool
     */
    public function triggerPasswordReset($email)
    {
        try {
            $user = $this->sentry->getUserProvider()->findByLogin(e($email));

            $this->dispatcher->fire('sentinel.user.reset', [
                'user' => $user,
                'code' => $user->getResetPasswordCode()
            ]);

            return new SuccessResponse(trans('Sentinel::users.emailinfo'), ['user' => $user]);
        } catch (UserNotFoundException $e) {
            // The user is trying to send a password reset link to an account that doesn't
            // exist.  This could be a vector for determining valid existing accounts,
            // so we will send a vague response without actually doing anything.
            $message = trans('Sentinel::users.emailinfo');

            return new SuccessResponse($message, []);
        }
    }


    /**
     * Validate a password reset link
     *
     * @param $id
     * @param $code
     *
     * @return FailureResponse
     */
    public function validateResetCode($id, $code)
    {
        try {
            $user = $this->sentry->findUserById($id);

            if (!$user->checkResetPasswordCode($code)) {
                return new FailureResponse(trans('Sentinel::users.invalidreset'), ['user' => $user]);
            }

            return new SuccessResponse(null);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
    }

    /**
     * Process the password reset request
     *
     * @param  int $id
     * @param  string $code
     *
     * @return Array
     */
    public function resetPassword($id, $code, $password)
    {
        try {
            // Grab the user
            $user = $this->sentry->getUserProvider()->findById($id);

            // Attempt to reset the user password
            if ($user->attemptResetPassword($code, $password)) {

                // Fire the 'password reset' event
                $this->dispatcher->fire('sentinel.password.reset', ['user' => $user]);

                return new SuccessResponse(trans('Sentinel::users.passwordchg'), ['user' => $user]);
            }

            return new FailureResponse(trans('Sentinel::users.problem'), ['user' => $user]);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
    }

    /**
     * Process a password change request
     *
     * @param $data
     *
     * @return FailureResponse|SuccessResponse
     */
    public function changePassword($data)
    {
        try {
            $user = $this->sentry->getUserProvider()->findById($data['id']);

            // Does the old password input match the user's existing password?
            if ($user->checkHash(e($data['oldPassword']), $user->getPassword())) {

                // Set the new password (Sentry will hash it behind the scenes)
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
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
    }

    /**
     * Change a user's password without checking their old password first
     *
     * @param $data
     *
     * @return FailureResponse|SuccessResponse
     */
    public function changePasswordWithoutCheck($data)
    {
        try {
            $user = $this->sentry->getUserProvider()->findById($data['id']);

            // Set the new password (Sentry will hash it behind the scenes)
            $user->password = e($data['newPassword']);

            if ($user->save()) {

                // User saved
                $this->dispatcher->fire('sentinel.user.passwordchange', ['user' => $user]);

                return new SuccessResponse(trans('Sentinel::users.passwordchg'), ['user' => $user]);
            }

            // User not Saved
            return new FailureResponse(trans('Sentinel::users.passwordprob'), ['user' => $user]);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
    }

    /**
     * Process a change password request.
     *
     * @return BaseResponse
     */
    public function changeGroupMemberships($userId, $selections)
    {
        try {
            $user = $this->sentry->getUserProvider()->findById(e($userId));

            // Gather all available groups
            $allGroups = $this->sentry->getGroupProvider()->findAll();

            // Update group memberships
            foreach ($allGroups as $group) {
                if (isset($selections[$group->name])) {
                    //The user should be added to this group
                    $user->addGroup($group);
                } else {
                    // The user should be removed from this group
                    $user->removeGroup($group);
                }
            }

            return new SuccessResponse(trans('Sentinel::users.memberships'), ['user' => $user]);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
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
        try {
            // Find the user using the user id
            $throttle = $this->sentry->findThrottlerByUserId($id);

            // Suspend the user
            $throttle->suspend();

            // Fire the 'user suspended' event
            $this->dispatcher->fire('sentinel.user.suspended', ['userId' => $id]);

            return new SuccessResponse(trans('Sentinel::users.suspended'), ['userId' => $id]);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
    }

    /**
     * Remove a users' suspension.
     *
     * @param $id
     *
     * @return array [type]     [description]
     *
     */
    public function unSuspend($id)
    {
        try {
            // Find the user using the user id
            $throttle = $this->sentry->findThrottlerByUserId($id);

            // Un-suspend the user
            $throttle->unsuspend();

            // Fire the 'user un-suspended' event
            $this->dispatcher->fire('sentinel.user.unsuspended', ['userId' => $id]);

            return new SuccessResponse(trans('Sentinel::users.unsuspended'), ['userId' => $id]);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
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
        try {
            $user = $this->sentry->getUserProvider()->findById($id);

            // Find the user using the user id
            $throttle = $this->sentry->findThrottlerByUserId($user->id);

            // Ban the user
            $throttle->ban();

            // Clear the persist code
            $user->persist_code = null;
            $user->save();

            // Fire the 'banned user' event
            $this->dispatcher->fire('sentinel.user.banned', ['user' => $user]);

            return new SuccessResponse(trans('Sentinel::users.banned'), ['userId' => $id]);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
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
        try {
            // Find the user using the user id
            $throttle = $this->sentry->findThrottlerByUserId($id);

            // Un-ban the user
            $throttle->unBan();

            // Fire the 'un-ban user event'
            $this->dispatcher->fire('sentinel.user.unbanned', ['userId' => $id]);

            return new SuccessResponse(trans('Sentinel::users.unbanned'), ['userId' => $id]);
        } catch (UserNotFoundException $e) {
            $message = trans('Sentinel::sessions.invalid');

            return new ExceptionResponse($message);
        }
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
     * @param  mixed $identifier
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
     * @param  User $user
     * @param  string $token
     *
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
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
        try {
            return $this->sentry->findUserByCredentials($credentials);
        } catch (UserNotFoundException $e) {
            return null;
        }
    }

    /**
     * Return all the registered users
     *
     * @return Collection
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
     * @param  array $credentials
     *
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
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
