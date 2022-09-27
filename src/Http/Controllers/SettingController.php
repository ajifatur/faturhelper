<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Ajifatur\FaturHelper\Models\Setting;

class SettingController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // // Check the access
        // has_access(__METHOD__, Auth::user()->role_id);

        // Get timezones
        $timezones = timezone_identifiers_list(2047);

        // View
        return view('faturhelper::admin/setting/index', [
            'timezones' => $timezones
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
        // Update via AJAX
        if($request->isAjax == true) {
            // Update the setting
            $setting = Setting::where('code','=',$request->code)->first();
            $setting->content = $request->content;
            $setting->save();

            // Response
            return response()->json("Success!");
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'setting.name' => 'required',
            'setting.timezone' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update or create the setting
            foreach($request->get('setting') as $key=>$value) {
                // Change config.app
                if($key == 'timezone') {
                    $contents = File::get(config_path('app.php'));
                    $contents = str_replace("'timezone' => '".config('app.timezone')."'", "'timezone' => '".$value."'", $contents);
                    File::put(config_path('app.php'), $contents);
                }

                // If the value is script
                if($key == 'google_maps' || $key == 'google_tag_manager')
                    $value = htmlentities($value);

                // Update or create
                $setting = Setting::updateOrCreate(
                    ['code' => $key],
                    ['content' => $value]
                );
            }

            // Redirect
            return redirect()->route('admin.setting.index')->with(['message' => 'Berhasil mengupdate data.']);
        }
    }
}
