<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsInspector
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
        if (Auth::user()->type != User::INSPECTOR) {
            return abort(401, 'دسترسی به این صفحه مجاز نمی باشد.');
        }
        return $next($request);
    }
}
