<?php namespace Sentinel;

use Sentinel\Repo\User\UserInterface;
use Sentinel\Repo\Group\GroupInterface;
use Sentinel\Service\Form\Register\RegisterForm;
use Sentinel\Service\Form\User\UserForm;
use Sentinel\Service\Form\ResendActivation\ResendActivationForm;
use Sentinel\Service\Form\ForgotPassword\ForgotPasswordForm;
use Sentinel\Service\Form\ChangePassword\ChangePasswordForm;
use Sentinel\Service\Form\SuspendUser\SuspendUserForm;
use BaseController, View, Input, Event, Redirect, Session, Config;

class UserController extends BaseController {

    protected $user;
    protected $group;
    protected $registerForm;
    protected $userForm;
    protected $resendActivationForm;
    protected $forgotPasswordForm;
    protected $changePasswordForm;
    protected $suspendUserForm;

    /**
     * Instantiate a new UserController
     */
    public function __construct(
        UserInterface $user,
        GroupInterface $group,
        RegisterForm $registerForm,
        UserForm $userForm,
        ResendActivationForm $resendActivationForm,
        ForgotPasswordForm $forgotPasswordForm,
        ChangePasswordForm $changePasswordForm,
        SuspendUserForm $suspendUserForm)
    {
        $this->user = $user;
        $this->group = $group;
        $this->registerForm = $registerForm;
        $this->userForm = $userForm;
        $this->resendActivationForm = $resendActivationForm;
        $this->forgotPasswordForm = $forgotPasswordForm;
        $this->changePasswordForm = $changePasswordForm;
        $this->suspendUserForm = $suspendUserForm;

        //Check CSRF token on POST
        $this->beforeFilter('Sentinel\csrf', array('on' => array('post', 'put', 'delete')));

        // Set up Auth Filters
        $this->beforeFilter('Sentinel\auth', array('only' => array('show', 'edit', 'update', 'change' )));
        $this->beforeFilter('Sentinel\hasAccess:admin', array('only' => array( 'index', 'create', 'add', 'destroy', 'suspend', 'unsuspend', 'ban', 'unban')));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->user->all();

        return View::make('Sentinel::users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function register()
    {
        // Is this user already signed in?
        if (\Sentry::check()) {
            return Redirect::route(Config::get('Sentinel::config.post_login'));
        }

        // Is registration enabled?
        $registration = Config::get('Sentinel::config.registration');

        // If not, take them back to the home page and show an error message
        if (!$registration)
        {
            Session::flash('error', trans('Sentinel::users.inactive_reg'));
            return Redirect::route('home');
        }

        // Show the registration form
        return View::make('Sentinel::users.create');
    }

    /**
     * Store a newly created user.
     *
     * @return Response
     */
    public function store()
    {
        // Collect Data
        $data = Input::all();
        $data['groups'] = Config::get('Sentinel::config.default_user_groups');

        // Form Processing
        $result = $this->registerForm->save( $data );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route(Config::get('Sentinel::config.post_confirmation_sent', 'home'));

        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('Sentinel\register')
                ->withInput()
                ->withErrors( $this->registerForm->errors() );
        }
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        if (View::exists('Sentinel::users.new'))
        {
            return View::make('Sentinel::users.new');
        }
        else
        {
            return View::make('Sentinel::users.create');
        }

    }

    /**
     * Allow an admin user to create a new user account
     *
     * @return Response
     */
    public function add()
    {
        // Collect Data
        $data = Input::all();
        $data['groups'] = Config::get('Sentinel::config.default_user_groups');

        // Form Processing
        $result = $this->registerForm->save( $data );

        if( $result['success'] )
        {
            if ($result['activated'])
            {
                $result['message'] = trans('Sentinel::users.addedactive');
            }
            else
            {
                $result['message'] = trans('Sentinel::users.added');
            }

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('users.index');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('users.create')
                ->withInput()
                ->withErrors( $this->registerForm->errors() );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $isOwner = $this->profileOwner($id);
        if($isOwner !== true){
            return $isOwner;
        }

        $user = $this->user->byId($id);

        return View::make('Sentinel::users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $isOwner = $this->profileOwner($id);

        if($isOwner !== true){
            return $isOwner;
        }

        $user = $this->user->byId($id);

        $currentGroups = $user->getGroups()->toArray();
        $userGroups = array();
        foreach ($currentGroups as $group) {
            array_push($userGroups, $group['name']);
        }
        $allGroups = $this->group->all();

        return View::make('Sentinel::users.edit')->with('user', $user)->with('userGroups', $userGroups)->with('allGroups', $allGroups);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $isOwner = $this->profileOwner($id);
        if($isOwner !== true){
            return $isOwner;
        }

        // Form Processing
        $result = $this->userForm->update( Input::all() );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::action('Sentinel\UserController@show', array($id));

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('Sentinel\UserController@edit', array($id))
                ->withInput()
                ->withErrors( $this->userForm->errors() );
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        if ($this->user->destroy($id))
        {
            Session::flash('success', 'User Deleted');
            return Redirect::action('Sentinel\UserController@index');
        }
        else
        {
            Session::flash('error', 'Unable to Delete User');
            return Redirect::action('Sentinel\UserController@index');
        }
    }

    /**
     * Activate a new user
     * @param  int $id
     * @param  string $code
     * @return Response
     */
    public function activate($id, $code)
    {
        $result = $this->user->activate($id, $code);

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('home');
        }
    }

    /**
     * Process resend activation request
     * @return Response
     */
    public function resend()
    {
        // Form Processing
        $result = $this->resendActivationForm->resend( Input::all() );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route(Config::get('Sentinel::config.post_confirmation_sent'));
        }
        else
        {
            Session::flash('error', $result['message']);
            return Redirect::route('Sentinel\resendActivationForm')
                ->withInput()
                ->withErrors( $this->resendActivationForm->errors() );
        }
    }

    /**
     * Process Forgot Password request
     * @return Response
     */
    public function forgot()
    {
        // Form Processing
        $result = $this->forgotPasswordForm->forgot( Input::all() );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        }
        else
        {
            Session::flash('error', $result['message']);
            return Redirect::route('Sentinel\forgotPasswordForm')
                ->withInput()
                ->withErrors( $this->forgotPasswordForm->errors() );
        }
    }

    /**
     * Process a password reset request link
     * @param  [type] $id   [description]
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function reset($id, $code)
    {
        $result = $this->user->resetPassword($id, $code);

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('home');
        }
    }

    /**
     * Process a password change request
     * @param  int $id
     * @return redirect
     */
    public function change($id)
    {

        $data = Input::all();
        $data['id'] = $id;

        // Form Processing
        $result = $this->changePasswordForm->change( $data );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::back();
        } 
        else
        {
            Session::flash('error', $result['message']);
            return Redirect::action('Sentinel\UserController@edit', array($id))
                ->withInput()
                ->withErrors( $this->changePasswordForm->errors() );
        }
    }

    /**
     * Process a suspend user request
     * @param  int $id
     * @return Redirect
     */
    public function suspend($id)
    {
        // Form Processing
        $result = $this->suspendUserForm->suspend( Input::all() );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::action('Sentinel\UserController@index');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('Sentinel\UserController@suspend', array($id))
                ->withInput()
                ->withErrors( $this->suspendUserForm->errors() );
        }
    }

    /**
     * Unsuspend user
     * @param  int $id
     * @return Redirect
     */
    public function unsuspend($id)
    {
        $result = $this->user->unSuspend($id);

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::action('Sentinel\UserController@index');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('Sentinel\UserController@index');
        }
    }

    /**
     * Ban a user
     * @param  int $id
     * @return Redirect
     */
    public function ban($id)
    {
        $result = $this->user->ban($id);

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::action('Sentinel\UserController@index');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('Sentinel\UserController@index');
        }
    }

    public function unban($id)
    {
        $result = $this->user->unBan($id);

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::action('Sentinel\UserController@index');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('Sentinel\UserController@index');
        }
    }

    /**
    * Check if the current user can update a profile
    * @param $id
    * @return bool|\Illuminate\Http\RedirectResponse
    */
    protected function profileOwner($id)
    {
        $user = \Sentry::getUser();
        if ($id != Session::get('userId') && (!$user->hasAccess('admin'))) {
            Session::flash('error', trans('Sentinel::users.noaccess'));
            return Redirect::route(Config::get('Sentinel::config.post_login'));
        }
        return true;
    }

}


