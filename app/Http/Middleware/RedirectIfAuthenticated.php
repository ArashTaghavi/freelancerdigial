<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->type == User::USER)
                return redirect('/user-panel');
            if (Auth::user()->type == User::INSPECTOR)
                return redirect('/inspector-panel');
            if (Auth::user()->type == User::CLIENT)
                return redirect('/client-panel');
            if (Auth::user()->type == User::TEAM)
                return redirect('/team-panel');
        }

        return $next($request);
    }
}
