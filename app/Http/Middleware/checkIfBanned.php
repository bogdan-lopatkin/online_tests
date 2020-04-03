<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class checkIfBanned
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user() && auth()->user()->banned) {
            abort(403, 'Вы забанены');
        } else {
            return $next($request);
        }
    }
}
