<?php

namespace Ajifatur\FaturHelper\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->check() && $request->user()->role->is_admin == 1) {
            if($request->user()->status == 1)
                return $next($request);
            else
                abort(403);
        }
        elseif(Auth::guard($guard)->check() && $request->user()->role->is_admin == 0) {
            abort(403);
        }
        
        return redirect()->route('auth.login');
    }
}
