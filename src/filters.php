<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/


Route::filter('Sentinel\auth', function()
{
	if (!Sentry::check()) return Redirect::guest(Config::get('Sentinel::config.routes.login.route'));
});

Route::filter('Sentinel\hasAccess', function($route, $request, $value)
{
	if (!Sentry::check()) return Redirect::guest(Config::get('Sentinel::config.routes.login.route'));

	$userId = Route::input('users');

	try
	{
		$user = Sentry::getUser();

		if ( $userId != Session::get('userId') && (! $user->hasAccess($value)) )
		{
			Session::flash('error', trans('Sentinel::users.noaccess'));
			return Redirect::route('home');
		}
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		Session::flash('error', trans('Sentinel::users.notfound'));
		return Redirect::guest(Config::get('Sentinel::config.routes.login.route'));
	}
});

Route::filter('Sentinel\inGroup', function($route, $request, $value)
{
	if (!Sentry::check()) return Redirect::guest(Config::get('Sentinel::config.routes.login.route'));

	// we need to determine if a non admin user 
	// is trying to access their own account.
    $userId = Route::input('id');

	try
	{
		$user = Sentry::getUser();
		 
		$group = Sentry::findGroupByName($value);
		 
		if ($userId != Session::get('userId') && (! $user->inGroup($group))  )
		{
			Session::flash('error', trans('Sentinel::users.noaccess'));
			return Redirect::route('home');
		}
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
		Session::flash('error', trans('Sentinel::users.notfound'));
		return Redirect::guest(Config::get('Sentinel::config.routes.login.route'));
	}
	 
	catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
	{
		Session::flash('error', trans('Sentinel::groups.notfound'));
		return Redirect::guest(Config::get('Sentinel::config.routes.login.route'));
	}
});
// thanks to http://laravelsnippets.com/snippets/sentry-route-filters


/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('Sentinel\csrf', function()
{
    if (Session::token() !== Input::get('_token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});