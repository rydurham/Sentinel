<?php namespace Sentinel;

use Illuminate\Http\Response;
use Sentinel\Repositories\Group\SentinelGroupManagerInterface;
use Sentinel\Repositories\User\SentinelUserManagerInterface;
use Sentinel\Services\Forms\ChangePasswordForm;
use Sentinel\Services\Forms\ForgotPasswordForm;
use Sentinel\Services\Forms\RegisterForm;
use Sentinel\Services\Forms\ResendActivationForm;
use Sentinel\Services\Forms\UserCreateForm;
use BaseController, View, Input, Event, Redirect, Session, Config;

class RegistrationController extends BaseController {

	protected $user;
	protected $group;
	protected $registerForm;
	protected $resendActivationForm;
	protected $forgotPasswordForm;

	/**
	 * Instantiate a new UserController
	 */
	public function __construct(
		SentinelUserManagerInterface $user,
		SentinelGroupManagerInterface $group,
        RegisterForm $registerForm,
        ResendActivationForm $resendActivationForm,
        ForgotPasswordForm $forgotPasswordForm
    )
	{
		$this->user = $user;
		$this->group = $group;
		$this->registerForm = $registerForm;
		$this->resendActivationForm = $resendActivationForm;
		$this->forgotPasswordForm = $forgotPasswordForm;

		//Check CSRF token on POST
		$this->beforeFilter('Sentinel\csrf', array('on' => array('post', 'put', 'delete')));

	}

	/**
     * Show the registration form, if registration is allowed
     *
     * @return Response
     */
    public function registration()
    {
        $registration = Config::get('Sentinel::config.registration');

        if (!$registration)
        {
            Session::flash('error', trans('Sentinel::users.inactive_reg'));
            return Redirect::route('home');
        }

        return View::make('Sentinel::users.create');
    }

	/**
	 * Process a registration request
	 *
	 * @return Response
	 */
	public function register()
	{
        // Collect Data
        $data = Input::all();
        $data['groups'] = Config::get('Sentinel::config.default_user_groups');

        // Forms Processing
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
	public function resendActivation()
	{
		// Forms Processing
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
	public function forgotPassword()
	{
		// Forms Processing
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

}


