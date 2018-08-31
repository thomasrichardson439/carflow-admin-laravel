<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->admin) {
            return $next($request);
        } elseif (Auth::user()) {
            abort(404);
        }

        return redirect('/login');
    }
}
