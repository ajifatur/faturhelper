<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use DB;
use Schema;
use Illuminate\Http\Request;

class DatabaseController extends \App\Http\Controllers\Controller
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
        has_access(method(__METHOD__), Auth::user()->role_id);

        // Get tables
        $tables = DB::select('SHOW TABLES');

        // Get table columns
        foreach($tables as $key=>$table) {
            $tables[$key]->name = $table->{'Tables_in_'.env('DB_DATABASE')};
            $tables[$key]->columns = DB::select('DESCRIBE '.$tables[$key]->name);
            $tables[$key]->latest_data = Schema::hasColumn($tables[$key]->name, 'updated_at') ? DB::table($tables[$key]->name)->latest('updated_at')->first() : false;
        }

        // View
        return view('faturhelper::admin/database/index', [
            'tables' => $tables
        ]);
    }
}
