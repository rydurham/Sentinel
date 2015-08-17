<?php

namespace Sentinel\Middleware;

use Closure;
use Sentry;

class SentryGuest
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
        if (Sentry::check()) {
            $destination = config('sentinel.redirect_if_authenticated', 'home');
            return redirect()->route($destination);
        }

        return $next($request);
    }
}
