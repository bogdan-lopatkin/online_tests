<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfAdmin
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
        if ($request->user() && $request->user()->type != ‘admin’)
        {
            return new Response(view(‘unauthorized’)->with(‘role’, ‘ADMIN’));
        }
         else {
             return $next($request);
         }
    }
}
