<?php

namespace PyroMans\Http\Middleware;

use DB;
use Closure;
use PyroMans\Auxillary\Traits\SharedBackend;

class AdminMiddleware
{
    use SharedBackend;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()) {
            return redirect('auth/login');
        }

        $this->getSharedVars();
        //dd($this->newMsg);
        view()->share('newMsg', $this->newMsg);
        view()->share('count', $this->count);
        view()->share('user', $this->user);

        /*SQL palieren*/
        /*DB::listen(function ($query) {
            dump($query->sql);
        });*/

        return $next($request);
    }
}
