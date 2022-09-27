<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // Get routes
        $routes = collect(Route::getRoutes())->map(function($route) {
            if(in_array('web', $route->middleware()) || in_array('api', $route->middleware())) {
                return [
                    'name' => $route->getName(),
                    'url' => $route->uri(),
                    'method' => $route->methods()[0],
                    'actionName' => $route->getActionName(),
                    'actionMethod' => $route->getActionMethod(),
                    'parameterName' => $route->parameterNames(),
                    'middleware' => $route->middleware(),
                ];
            }
        });

        // View
        return view('faturhelper::admin/route/index', [
            'routes' => $routes
        ]);
    }
}
