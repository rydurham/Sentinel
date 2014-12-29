<?php namespace Sentinel;

use Sentinel\Repositories\Session\SentinelSessionManagerInterface;
use Sentinel\Services\Forms\LoginForm;
use BaseController;
use View, Input, Event, Redirect, Session, Config;

class SessionController extends BaseController {

	/**
	 * Member Vars
	 */
	protected $session;
	protected $loginForm;

	/**
	 * Constructor
	 */
	public function __construct(SentinelSessionManagerInterface $session, LoginForm $loginForm)
	{
		$this->session = $session;
		$this->loginForm = $loginForm;
	}

	/**
	 * Show the login form
	 */
	public function create()
	{
        //dd(Form::open(array('action' => 'Sentinel\SessionController@store')));

        return View::make('Sentinel::sessions.login');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Forms Processing
        $result = $this->loginForm->save( Input::all() );

        if( $result['success'] )
        {
            Event::fire('sentinel.user.login', array(
            	'user' => $result['user']
            ));

            // Success!
            $redirect_route = Config::get('Sentinel::config.post_login');
            return Redirect::intended(route($redirect_route));

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
		$redirect_route = Config::get('Sentinel::routing.post_logout', 'home');
		return Redirect::route($redirect_route);
	}

}
