<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class StatsController extends \App\Http\Controllers\Controller
{
    /**
     * Display user stats.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // View
        return view('faturhelper::admin/stats/user');
    }

    /**
     * Display visitor stats.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function visitor(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // View
        return view('faturhelper::admin/stats/visitor');
    }

    /**
     * Display visitor location stats.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function visitorLocation(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // View
        return view('faturhelper::admin/stats/visitor-location');
    }
}
