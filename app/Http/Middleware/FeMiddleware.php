<?php

namespace PyroMans\Http\Middleware;

use Closure;
use PyroMans\Setting;

class FeMiddleware
{
    /**
     * Used for var sharing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $meta = Setting::first();
        view()->share('meta', $meta);

        /*SQL palieren*/
        /*DB::listen(function ($query) {
            dump($query->sql);
        });*/

        return $next($request);
    }
}
