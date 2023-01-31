<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Ajifatur\FaturHelper\Models\User;
use Ajifatur\FaturHelper\Models\Visitor;
use Ajifatur\FaturHelper\Models\Setting;

class DashboardController extends \App\Http\Controllers\Controller
{
    /**
     * Show the dashboard page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the random quote
        // $quote = quote('random');

        // View
        return view('faturhelper::admin/dashboard/index', [
            // 'quote' => $quote
        ]);
    }

    /**
     * Show the summary page.
     *
     * @return \Illuminate\Http\Response
     */
    public function summary()
    {
        // Count users
        $users = [
            'overall' => User::has('role')->count(),
            'today' => User::has('role')->whereDate('created_at','=',date('Y-m-d'))->count()
        ];

        // Count visitors
        $visitors = [
            'overall' => Visitor::has('user')->count(),
            'today' => Visitor::has('user')->whereDate('created_at','=',date('Y-m-d'))->count()
        ];

        // Count settings
        $settings = [
            'overall' => Setting::whereNotIn('code',['period_alias', 'period_visibility'])->count(),
            'empty' => Setting::whereNotIn('code',['period_alias', 'period_visibility'])->where('content','=','')->orWhere('content','=',null)->count()
        ];

        // View
        return view('faturhelper::admin/dashboard/summary', [
            'users' => $users,
            'visitors' => $visitors,
            'settings' => $settings
        ]);
    }
}