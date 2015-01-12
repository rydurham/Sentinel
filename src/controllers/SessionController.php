<?php namespace Sentinel;

use BaseController;
use Illuminate\Http\Response;
use Sentinel\Managers\Session\SentinelSessionManagerInterface;
use Sentinel\Services\Forms\LoginForm;
use Sentinel\Traits\SentinelRedirectionTrait;
use Sentinel\Traits\SentinelViewfinderTrait;
use View, Input, Event, Redirect, Session, Config;

class SessionController extends BaseController {

	/**
	 * Members
	 */
	protected $sessionManager;
	protected $loginForm;

    /**
     * Traits
     */
    use SentinelRedirectionTrait;
    use SentinelViewfinderTrait;

	/**
	 * Constructor
	 */
	public function __construct(SentinelSessionManagerInterface $sessionManager, LoginForm $loginForm)
	{
		$this->session = $sessionManager;
		$this->loginForm = $loginForm;
	}

	/**
	 * Show the login form
	 */
	public function create()
	{
        // Is this user already signed in?
        if (\Sentry::check()) {
            return $this->redirectTo('session.store');
        }

        // No - they are not signed in.  Show the login form.
        return $this->viewFinder('Sentinel::sessions.login');
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
            if (! Config::get('Sentinel::views.enabled')){
                // Views are disabled - return json instead
                return Response::json('success', 200);
            }

            // Views are enabled, so go to the determined route
            $redirect_route = Config::get('Sentinel::routing.session.store');
            return Redirect::intended($this->generateUrl($redirect_route));

        } else {
            // There was a problem - unrelated to Form validation.
            if (! Config::get('Sentinel::views.enabled')){
                // Views are disabled - return json instead
                return Response::json($result->getMessage(), 400);
            }

            Session::flash('error', $result->getMessage());
            return Redirect::route('sentinel.session.create')
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
