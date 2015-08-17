<?php

namespace Sentinel\Middleware;

use Closure;
use Session;
use Sentry;
use Illuminate\Contracts\Routing\Middleware;

class SentryAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // First make sure there is an active session
        if (!Sentry::check()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('sentinel.login'));
            }
        }

        // Now check to see if the current user has the 'admin' permission
        if (!Sentry::getUser()->hasAccess('admin')) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                Session::flash('error', trans('Sentinel::users.noaccess'));

                return redirect()->route('sentinel.login');
            }
        }

        // All clear - we are good to move forward
        return $next($request);
    }
}
