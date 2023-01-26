<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturHelper\Models\Period;
use Ajifatur\FaturHelper\Models\Setting;

class PeriodController extends \App\Http\Controllers\Controller
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

        // Get periods
        $periods = Period::orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/period/index', [
            'periods' => $periods
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // View
        return view('faturhelper::admin/period/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Get the latest period
            $latest_period = Period::orderBy('num_order','desc')->first();

            // Save the period
            $period = new Period;
            $period->name = $request->name;
            $period->status = 0;
            $period->num_order = $latest_period ? $latest_period->num_order + 1 : 1;
            $period->save();

            // Redirect
            return redirect()->route('admin.period.index')->with(['message' => 'Berhasil menambah data.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // Get the period
        $period = Period::findOrFail($id);

        // View
        return view('faturhelper::admin/period/edit', [
            'period' => $period
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update the period
            $period = Period::find($request->id);
            $period->name = $request->name;
            $period->save();

            // Redirect
            return redirect()->route('admin.period.index')->with(['message' => 'Berhasil mengupdate data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);
        
        // Get the period
        $period = Period::find($request->id);

        // Check period status
        if($period->status == 1) {
            // Redirect
            return redirect()->route('admin.period.index')->with(['message' => 'Tidak bisa menghapus data yang berstatus aktif.']);
        }
        else {
            // Delete the period
            $period->delete();

            // Redirect
            return redirect()->route('admin.period.index')->with(['message' => 'Berhasil menghapus data.']);
        }
    }

    /**
     * Display a listing of the resource to be sorted.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // Get periods
        $periods = Period::orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/period/reorder', [
            'periods' => $periods
        ]);
    }

    /**
     * Sort the resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        // Loop periods
        if(count($request->get('ids')) > 0) {
            foreach($request->get('ids') as $key=>$id) {
                $period = Period::find($id);
                if($period) {
                    $period->num_order = $key + 1;
                    $period->save();
                }
            }

            echo 'Berhasil mengurutkan data.';
        }
        else echo 'Terjadi kesalahan dalam mengurutkan data.';
    }

    /**
     * Show the setting form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setting(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // Get periods
        $periods = Period::orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/period/setting', [
            'periods' => $periods
        ]);
    }

    /**
     * Store the setting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function set(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'period' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update the period alias
            $period_alias = Setting::where('code','=','period_alias')->first();
            $period_alias->content = $request->name;
            $period_alias->save();

            // Update the period status from active to inactive
            $active_period = Period::where('status','=',1)->first();
            $active_period->status = 0;
            $active_period->save();

            // Update the selected period status to active
            $period = Period::find($request->period);
            $period->status = 1;
            $period->save();

            // Redirect
            return redirect()->route('admin.period.setting')->with(['message' => 'Berhasil mengupdate data.']);
        }
    }

    /**
     * Change the period session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {
        // Update session
        $request->session()->put('period', $request->id);

        // Redirect
        return redirect(url()->previous());
    }
}
