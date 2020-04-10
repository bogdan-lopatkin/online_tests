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
        if (!auth()->user() || is_null(auth()->user()->roles->where('id',1)->first())) {
            abort(403, 'Доступ запрещен');
        } else {
            return $next($request);
        }
    }
}
