<?php

namespace Sentinel\Middleware;

use Closure;
use Sentry;

class SentryAuth
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
        if (!Sentry::check()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                $request->session()->reflash();
                return redirect()->guest(route('sentinel.login'));
            }
        }

        return $next($request);
    }
}
