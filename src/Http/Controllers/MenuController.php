<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ajifatur\FaturHelper\Models\MenuHeader;

class MenuController extends \App\Http\Controllers\Controller
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

        // Get menu headers
        $menu_headers = MenuHeader::orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/menu/index', [
            'menu_headers' => $menu_headers
        ]);
    }
}
