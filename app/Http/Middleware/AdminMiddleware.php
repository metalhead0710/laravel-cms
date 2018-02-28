<?php

namespace Mik\Http\Middleware;

use Closure;

class AdminMiddleware
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
    	if(!$request->user())
    	{
			return redirect('auth/login');
		}
        /*else
        {
            return redirect('home');
        }*/

		return $next($request);
    }
}
