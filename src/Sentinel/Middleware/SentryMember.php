<?php

namespace Sentinel\Middleware;

use Closure;
use Sentry;
use Session;

class SentryMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $group
     * @return mixed
     */
    public function handle($request, Closure $next, $group)
    {
        if (!Sentry::check()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('sentinel.login'));
            }
        }

        // Find the specified group
        $group = Sentry::findGroupByName($group);

        // Now check to see if the current user is a member of the specified group
        if (!Sentry::getUser()->inGroup($group)) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                Session::flash('error', trans('Sentinel::users.noaccess'));

                return redirect()->route('sentinel.login');
            }
        }

        return $next($request);
    }
}
