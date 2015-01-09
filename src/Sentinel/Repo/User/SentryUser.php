<?php namespace Sentinel\Repo\User;

use Mail;
use Cartalyst\Sentry\Sentry;
use Sentinel\Repo\RepoAbstract;
use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;

class SentryUser extends RepoAbstract implements UserInterface {
    
    protected $sentry;
    protected $config;
    protected $dispatcher;

    /**
     * Construct a new SentryUser Object
     */
    public function __construct(Sentry $sentry, Repository $config, Dispatcher $dispatcher )
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
        $result = array();
        try {

            // Check for firstName or lastName values for backwards compatibility
            if (isset($data['firstName']) || isset($data['first_name']))
            {
                $data['first_name'] = (isset($data['firstName']) ? $data['firstName'] : $data['first_name']);
            }

            if (isset($data['lastName']) || isset($data['last_name']))
            {
                $data['last_name']  = (isset($data['lastName']) ? $data['lastName'] : $data['last_name']);
            }

            // Check to see if activation has been disabled in the config.
            if ($this->config->has('Sentinel::config.activation'))
            {
                if ($this->config->get('Sentinel::config.activation') == false)
                {
                    $data['activate'] = 1;
                }
            }

            //Attempt to register the user. 
            $credentials = array('email' => e($data['email']), 'password' => e($data['password']));
            if ($this->config->has('Sentinel::config.allow_usernames')  && $this->config->get('Sentinel::config.allow_usernames') == true)
            {
                if (array_key_exists('username', $data))
                {
                    $credentials['username'] = e($data['username']);
                }
                
            }

            $user = $this->sentry->register($credentials, array_key_exists('activate', $data));

            // Are there additional fields specified in the config?
            // If so, update them here. 
            if ($this->config->has('Sentinel::config.additional_user_fields'))
            {
                foreach ($this->config->get('Sentinel::config.additional_user_fields') as $key => $value) 
                {
                    if (array_key_exists($key, $data))
                    {
                        $user->$key = e($data[$key]);
                    }
                }

                $user->save();
            }

            foreach ($data['groups'] as $groupName) {
                $group = $this->sentry->getGroupProvider()->findByName($groupName);
                $user->addGroup($group);
            }

            //success!
            $result['success']   = true;
            $result['message']   = trans('Sentinel::users.created');
            $result['activated'] = array_key_exists('activate', $data);
            $result['user']      = $user;

            $this->dispatcher->fire('sentinel.user.registered', array(
                'user'      => $user,
                'activated' => array_key_exists('activate', $data)
            ));

            if (array_key_exists('activate', $data))
            {
                // This user has been automatically activated.  
                // Alter the return data as necessary
                $result['activated'] = true;
                $result['message'] = trans('Sentinel::users.createdactive');                
            }
        }
        catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.loginreq');
        }
        catch (\Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.exists');
        }

        return $result;
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     * @return Response
     */
    public function update($data)
    {
        $result = array();
        try
        {
            // Find the user using the user id
            $user = $this->sentry->findUserById($data['id']);

            // Check for firstName or lastName values for backwards compatibility
            if (isset($data['firstName']) || isset($data['first_name']))
            {
                $data['first_name'] = (isset($data['firstName']) ? $data['firstName'] : $data['first_name']);
            }

            if (isset($data['lastName']) || isset($data['last_name']))
            {
                $data['last_name']  = (isset($data['lastName']) ? $data['lastName'] : $data['last_name']);
            }

            // Update the user details
            $user->first_name = e($data['first_name']);
            $user->last_name = e($data['last_name']);

            // Update Email address? 
            if (array_key_exists('email', $data))
            {
                $user->email = $data['email'];
            }

            // Update username address? 
            if (array_key_exists('username', $data))
            {
                $user->username = $data['username'];
            }

            // Are there additional fields specified in the config?
            // If so, update them here. 
            if ($this->config->has('Sentinel::config.additional_user_fields'))
            {
                foreach ($this->config->get('Sentinel::config.additional_user_fields') as $key => $value) 
                {
                    if (array_key_exists($key, $data))
                    {
                        $user->$key = e($data[$key]);
                    }
                }
            }

            // Only Admins should be able to change group memberships. 
            $operator = $this->sentry->getUser();
            if ($operator->hasAccess('admin'))
            {
                // Update group memberships
                $allGroups = $this->sentry->getGroupProvider()->findAll();
                foreach ($allGroups as $group)
                {
                    if (isset($data['groups'][$group->id])) 
                    {
                        //The user should be added to this group
                        $user->addGroup($group);
                    } else {
                        // The user should be removed from this group
                        $user->removeGroup($group);
                    }
                }
            }

            // Update the user
            if ($user->save())
            {
                // User information was updated
                $this->dispatcher->fire('sentinel.user.updated', array(
                    'user' => $user, 
                ));

                $result['success'] = true;
                $result['message'] = trans('Sentinel::users.updated');
                $result['user']    = $user;
            }
            else
            {
                // User information was not updated
                $result['success'] = false;
                $result['message'] = trans('Sentinel::users.notupdated');
            }
        }
        catch (\Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.exists');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try
        {
            // Find the user using the user id
            $user = $this->sentry->findUserById($id);

            // Delete the user
            $user->delete();

            //Fire the sentinel.user.destroyed event
            $this->dispatcher->fire('sentinel.user.destroyed', array(
                'userId' => $id, 
            ));
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return false;
        }
        return true;
    }

    /**
     * Attempt activation for the specified user
     * @param  int $id   
     * @param  string $code 
     * @return bool       
     */
    public function activate($id, $code)
    {
        $result = array();
        try
        {
            // Find the user using the user id
            $user = $this->sentry->findUserById($id);

            // Attempt to activate the user
            if ($user->attemptActivation($code))
            {
                // User activation passed
                $this->dispatcher->fire('sentinel.user.activated', array(
                    'userId' => $id, 
                ));

                $result['success'] = true;
                $url = route('Sentinel\login');
                $result['message'] = trans('Sentinel::users.activated', array('url' => $url));
            }
            else
            {
                // User activation failed
                $result['success'] = false;
                $result['message'] = trans('Sentinel::users.notactivated');
            }
        }
        catch (\Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.exists');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }
        catch (\Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.alreadyactive');
        }
        return $result;
    }

    /**
     * Resend the activation email to the specified email address
     * @param  Array $data
     * @return Response
     */
    public function resend($data)
    {
        $result = array();
        try {
            //Attempt to find the user. 
            $user = $this->sentry->getUserProvider()->findByLogin(e($data['email']));

            if (!$user->isActivated())
            {
                // The user is not currently activated, so resend the welcome message
                $this->dispatcher->fire('sentinel.user.resend', array(
                    'user'     => $user,
                    'activated' => $user->activated,
                ));

                $result['success'] = true;
                $result['message'] = trans('Sentinel::users.emailconfirm');
                $result['user']    = $user;
            }
            else 
            {
                $result['success'] = false;
                $result['message'] = trans('Sentinel::users.alreadyactive');
            }

        }
        catch (\Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.exists');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }
        return $result;
    }

    /**
     * Handle a password reset rewuest
     * @param  Array $data 
     * @return Bool       
     */
    public function forgotPassword($data)
    {
        $result = array();
        try
        {
            $user = $this->sentry->getUserProvider()->findByLogin(e($data['email']));

            $this->dispatcher->fire('sentinel.user.forgot', array(
                'email' => $user->email,
                'userId' => $user->id,
                'resetCode' => $user->getResetPasswordCode()
            ));

            $result['success'] = true;
            $result['message'] = trans('Sentinel::users.emailinfo');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }
        return $result;
    }

    /**
     * Process the password reset request
     * @param  int $id   
     * @param  string $code 
     * @return Array
     */
    public function resetPassword($id, $code)
    {
        $result = array();
        try
        {
            // Find the user
            $user = $this->sentry->getUserProvider()->findById($id);
            $newPassword = $this->_generatePassword(8,8);

            // Attempt to reset the user password
            if ($user->attemptResetPassword($code, $newPassword))
            {
                // Email the reset code to the user
                $this->dispatcher->fire('sentinel.user.newpassword', array(
                    'email' => $user->email,
                    'newPassword' => $newPassword
                ));

                $result['success'] = true;
                $result['message'] = trans('Sentinel::users.emailpassword');
            }
            else
            {
                // Password reset failed
                $result['success'] = false;
                $result['message'] = trans('Sentinel::users.problem');
            }
        }
       catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }
        return $result;
    }

    /**
     * Process a change password request. 
     * @return Array $data
     */
    public function changePassword($data)
    {
        $result = array();
        try
        {
            $user = $this->sentry->getUserProvider()->findById($data['id']);        
        
            if ($user->checkHash(e($data['oldPassword']), $user->getPassword()))
            {
                //The oldPassword matches the current password in the DB. Proceed.
                $user->password = e($data['newPassword']);

                if ($user->save())
                {
                    // User saved
                    $this->dispatcher->fire('sentinel.user.passwordchange', array(
                        'userId' => $user->id, 
                    ));

                    $result['success'] = true;
                    $result['message'] = trans('Sentinel::users.passwordchg');
                }
                else
                {
                    // User not saved
                    $result['success'] = false;
                    $result['message'] = trans('Sentinel::users.passwordprob');
                }
            } 
            else 
            {
                // Password mismatch. Abort.
                $result['success'] = false;
                $result['message'] = trans('Sentinel::users.oldpassword');
            }                                        
        }
        catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            $result['success'] = false;
            $result['message'] = 'Login field required.';
        }
        catch (\Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.exists');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }
        return $result;
    }

    /**
     * Suspend a user
     * @param  int $id      
     * @param  int $minutes 
     * @return Array          
     */
    public function suspend($id, $minutes)
    {
        $result = array();
        try
        {
            // Find the user using the user id
            $throttle = $this->sentry->findThrottlerByUserId($id);

            //Set suspension time
            $throttle->setSuspensionTime($minutes);

            // Suspend the user
            $throttle->suspend();

            $this->dispatcher->fire('sentinel.user.suspended', array(
                'userId' => $id, 
            ));

            $result['success'] = true;
            $result['message'] = trans('Sentinel::users.suspended', array('minutes' => $minutes));
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }
        return $result;
    }

    /**
     * Remove a users' suspension.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function unSuspend($id)
    {
        $result = array();
        try
        {
            // Find the user using the user id
            $throttle = $this->sentry->findThrottlerByUserId($id);

            // Unsuspend the user
            $throttle->unsuspend();

            $this->dispatcher->fire('sentinel.user.unsuspended', array(
                'userId' => $id, 
            ));

            $result['success'] = true;
            $result['message'] = trans('Sentinel::users.unsuspended');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }
        return $result;
    }

    /**
     * Ban a user
     * @param  int $id 
     * @return Array     
     */
    public function ban($id)
    {
        $result = array();
        try
        {
            // Find the user using the user id
            $throttle = $this->sentry->findThrottlerByUserId($id);

            // Ban the user
            $throttle->ban();

            $this->dispatcher->fire('sentinel.user.banned', array(
                'userId' => $id, 
            ));

            $result['success'] = true;
            $result['message'] = trans('Sentinel::users.banned');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }
        return $result;
    }

    /**
     * Remove a users' ban
     * @param  int $id 
     * @return Array     
     */
    public function unBan($id)
    {
        $result = array();
        try
        {
            // Find the user using the user id
            $throttle = $this->sentry->findThrottlerByUserId($id);

            // Unban the user
            $throttle->unBan();

            $this->dispatcher->fire('sentinel.user.unbanned', array(
                'userId' => $id, 
            ));

            $result['success'] = true;
            $result['message'] = trans('Sentinel::users.unbanned');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $result['success'] = false;
            $result['message'] = trans('Sentinel::users.notfound');
        }
        return $result;
    }

    /**
     * Return a specific user from the given id
     * 
     * @param  integer $id
     * @return User
     */
    public function byId($id)
    {
        try
        {
            $user = $this->sentry->findUserById($id);
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return false;
        }
        return $user;
    }

    /**
     * Return a specific user from a given email address
     * 
     * @param  integer $id
     * @return User
     */
    public function byEmail($email)
    {
        try
        {
            $user = $this->sentry->findUserByLogin($email);
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return false;
        }
        return $user;
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
            if ($user->isActivated()) 
            {
                $user->status = "Active";
            } 
            else 
            {
                $user->status = "Not Active";
            }

            //Pull Suspension & Ban info for this user
            $throttle = $this->throttleProvider->findByUserId($user->id);

            //Check for suspension
            if($throttle->isSuspended())
            {
                // User is Suspended
                $user->status = "Suspended";
            }

            //Check for ban
            if($throttle->isBanned())
            {
                // User is Banned
                $user->status = "Banned";
            }
        }

        return $users;
    }

    /**
     * Select users based on an arbitrary where() condition
     * @param  string $field   Name of Field to be queried against
     * @param  string $operand Where comparison operand
     * @param  any $value      Value to be compared against
     * @return Illuminate\Database\Eloquent\Collection   User Set
     */
    public function where($field, $operand, $value)
    {
        $users = $this->sentry->getUserProvider()->createModel()->where($field, $operand, $value)->get();

        foreach ($users as $user) {
            if ($user->isActivated()) 
            {
                $user->status = "Active";
            } 
            else 
            {
                $user->status = "Not Active";
            }

            //Pull Suspension & Ban info for this user
            $throttle = $this->throttleProvider->findByUserId($user->id);

            //Check for suspension
            if($throttle->isSuspended())
            {
                // User is Suspended
                $user->status = "Suspended";
            }

            //Check for ban
            if($throttle->isBanned())
            {
                // User is Banned
                $user->status = "Banned";
            }
        }

        return $users;
    }

    /**
     * Provide a wrapper for Sentry::getUser()
     *
     * @return user object
     */
    public function getUser()
    {
        return $this->sentry->getUser();
    }


    /**
     * Generate password - helper function
     * From http://www.phpscribble.com/i4xzZu/Generate-random-passwords-of-given-length-and-strength
     *
     */
    protected function _generatePassword($length=9, $strength=4) {
        $vowels = 'aeiouy';
        $consonants = 'bcdfghjklmnpqrstvwxz';
        if ($strength & 1) {
               $consonants .= 'BCDFGHJKLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
               $vowels .= "AEIOUY";
        }
        if ($strength & 4) {
               $consonants .= '23456789';
        }
        if ($strength & 8) {
               $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }
}
