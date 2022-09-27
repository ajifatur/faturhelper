<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ajifatur\FaturHelper\Models\Meta;

class MetaController extends \App\Http\Controllers\Controller
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

        // Get metas
        $metas = ['description', 'keywords', 'author'];

        // View
        return view('faturhelper::admin/meta/index', [
            'metas' => $metas
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
            'meta.*' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update or create the meta
            foreach($request->get('meta') as $key=>$value) {
                $meta = Meta::updateOrCreate(
                    ['code' => $key],
                    ['content' => $value]
                );
            }

            // Redirect
            return redirect()->route('admin.meta.index')->with(['message' => 'Berhasil mengupdate data.']);
        }
    }
}
