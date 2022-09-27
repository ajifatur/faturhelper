<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Artisan;
use Illuminate\Http\Request;

class ArtisanController extends \App\Http\Controllers\Controller
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

        // Set artisans
        $artisans = [
            ['key'=> 'clear-compiled', 'title' => 'Clear Compiled', 'command' => 'php artisan clear-compiled'],
            ['key'=> 'cache:clear', 'title' => 'Clear Cache', 'command' => 'php artisan cache:clear'],
            ['key'=> 'config:clear', 'title' => 'Clear Config', 'command' => 'php artisan config:clear'],
            ['key'=> 'view:clear', 'title' => 'Clear View', 'command' => 'php artisan view:clear'],
        ];

        // View
        return view('faturhelper::admin/artisan/index', [
            'artisans' => $artisans
        ]);
    }

    /**
     * Run artisan command.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function run(Request $request)
    {
        // Run the command
        Artisan::call($request->key);

        // Return the output
        return response()->json(Artisan::output());
    }
}
