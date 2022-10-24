<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\Helpers\DateTimeExt;
use Ajifatur\FaturHelper\Models\Schedule;

class ScheduleController extends \App\Http\Controllers\Controller
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

        // Get schedules
        $schedules = Schedule::get()->toArray();
        foreach($schedules as $key=>$schedule) {
            $schedules[$key]['start'] = $schedule['started_at'];
            $schedules[$key]['end'] = $schedule['ended_at'];
            $schedules[$key]['sdatetext'] = DateTimeExt::full($schedule['started_at']);
            $schedules[$key]['edatetext'] = DateTimeExt::full($schedule['ended_at']);
            $schedules[$key]['sdaterangepicker'] = date("d/m/Y H:i", strtotime($schedule['started_at']));
            $schedules[$key]['edaterangepicker'] = date("d/m/Y H:i", strtotime($schedule['ended_at']));
            $schedules[$key]['daterange'] = DateTimeExt::merge([$schedule['started_at'], $schedule['ended_at']]);
        }

        if($request->ajax()) {
            return response()->json([
                'schedules' => $schedules,
                'businessDays' => [1,2,3,4,5,6] // Monday - Saturday
            ]);
        }

        // View
        return view('faturhelper::admin/schedule/index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);
        
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:200',
            'color' => 'required',
            'time' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Split time
            $time = DateTimeExt::split($request->time);

            // Save the schedule
            $schedule = $request->id == '' ? new Schedule : Schedule::find($request->id);
            $schedule->title = $request->title;
            $schedule->description = $request->description;
            $schedule->color = $request->color;
            $schedule->started_at = $time[0];
            $schedule->ended_at = $time[1];
            $schedule->save();

            // Redirect
            if($request->id == '')
                return redirect()->route('admin.schedule.index')->with(['message' => 'Berhasil menambah data.']);
            else
                return redirect()->route('admin.schedule.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Get the schedule
        $schedule = Schedule::find($request->id);

        // Delete the schedule
        $schedule->delete();

        // Redirect
        return redirect()->route('admin.schedule.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
