<?php namespace Sentinel;

use Sentinel\Repo\Session\SessionInterface;
use Sentinel\Service\Form\Login\LoginForm;
use BaseController;
use View, Input, Event, Redirect, Session, URL;

class SessionController extends BaseController {

	/**
	 * Member Vars
	 */
	protected $session;
	protected $loginForm;

	/**
	 * Constructor
	 */
	public function __construct(SessionInterface $session, LoginForm $loginForm)
	{
		$this->session = $session;
		$this->loginForm = $loginForm;
	}

	/**
	 * Show the login form
	 */
	public function create()
	{
		return View::make('Sentinel::sessions.login');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Form Processing
        $result = $this->loginForm->save( Input::all() );

        if( $result['success'] )
        {
            Event::fire('sentinel.user.login', array(
            							'userId' => $result['sessionData']['userId'],
            							'email' => $result['sessionData']['email']
            							));

            // Success!
            return Redirect::intended(route('home'));

        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('Sentinel\login')
                ->withInput()
                ->withErrors( $this->loginForm->errors() );
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		$this->session->destroy();
		Event::fire('sentinel.user.logout');
		return Redirect::route('home');
	}

}
