<?php

namespace App\Http\Middleware;

use Closure;

class CheckSubAccount
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
        if(auth()->user()->sub_account) {
            return back()->with('error', 'Permission denied. Your account is a sub account');
        }
        return $next($request);
    }
}
