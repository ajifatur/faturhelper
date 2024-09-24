<?php

namespace Ajifatur\FaturHelper\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use hisorange\BrowserDetect\Parser as Browser;
use Ajifatur\FaturHelper\Models\User;

class Logs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Get the user ID
        if($request->is('api/*')) {
            $user    = User::where('access_token','=',$request->get('access_token'))->first();
            $user_id = $user && $request->get('access_token') != null ? $user->id : null;
        }
        else {
            $user    = User::find(Auth::guard($guard)->check() ? $request->user()->id : null);
            $user_id = Auth::guard($guard)->check() ? $request->user()->id : null;
        }

        // Save log
        Log::build([
            'driver' => 'single',
            'path'   => storage_path('logs/activities-'.date('Y').'-'.date('m').'.log'),
        ])->info(
            json_encode([
                'user_id'       => $user_id,
                'user_name'     => $user ? $user->name : '',
                'user_role'     => $user ? $user->role->name ?? '' : '',
                'url'           => $request->fullUrl(),
                'method'        => $request->method(),
                'ajax'          => $request->ajax(),
                'ip'            => $request->ip(),
                'route'         => Route::currentRouteName(),
                'route_params'  => $request->query(),
                'is_bot'        => Browser::isBot()
            ])
        );

        return $next($request);
    }
}
