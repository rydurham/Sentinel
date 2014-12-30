<?php namespace Sentinel;

use BaseController;
use Illuminate\Http\Response;
use Sentinel\Repositories\Session\SentinelSessionManagerInterface;
use Sentinel\Services\Forms\LoginForm;
use Sentinel\Traits\SentinelRedirectionTrait;
use View, Input, Event, Redirect, Session, Config;

class SessionController extends BaseController {

	/**
	 * Members
	 */
	protected $session;
	protected $loginForm;

    /**
     * Traits
     */
    use SentinelRedirectionTrait;

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
        return View::make('Sentinel::sessions.login');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Gather the input
        $data = Input::all();

        // Validate the data
        $this->loginForm->validate($data);

        // Attempt the login
        $result = $this->session->store($data);

        // Did it work?
        if($result->isSuccessful())
        {
            // Login was successful.  Determine where we should go now.
            $redirect_route = Config::get('Sentinel::routing.session.store');
            return Redirect::intended($this->generateUrl($redirect_route));

        } else {
            // There was a problem - unrelated to Form validation.
            Session::flash('error', $result->getMessage());
            return Redirect::action('Sentinel\SessionController@create')
                ->withInput();
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

		return $this->redirectTo('session.destroy');
	}

}
