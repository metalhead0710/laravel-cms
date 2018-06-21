<?php

namespace PyroMans\Http\Middleware;

use Closure;
use PyroMans\User;
use PyroMans\Message;

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

		/* Shared variables */
        $newMsg = Message::where('isNew', true)->orderBy('created_at', 'DESC')->take(8)->get();
        $count = Message::where('isNew', true)->count();
        $user = User::first();
        view()->share('newMsg', $newMsg);
        view()->share('count', $count);
        view()->share('user', $user);

		return $next($request);
    }
}
