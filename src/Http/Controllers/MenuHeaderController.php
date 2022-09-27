<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ajifatur\FaturHelper\Models\MenuHeader;

class MenuHeaderController extends \App\Http\Controllers\Controller
{
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
        return view('faturhelper::admin/menu-header/create');
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
            // 'name' => 'required|max:200'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Get the latest menu header
            $latest_menu_header = MenuHeader::orderBy('num_order','desc')->first();

            // Save the menu header
            $menu_header = new MenuHeader;
            $menu_header->name = $request->name != '' ? $request->name : '';
            $menu_header->num_order = $latest_menu_header ? $latest_menu_header->num_order + 1 : 1;
            $menu_header->save();

            // Redirect
            return redirect()->route('admin.menu.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Get the menu header
        $menu_header = MenuHeader::findOrFail($id);

        // View
        return view('faturhelper::admin/menu-header/edit', [
            'menu_header' => $menu_header
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
            // 'name' => 'required|max:200'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update the menu header
            $menu_header = MenuHeader::find($request->id);
            $menu_header->name = $request->name != '' ? $request->name : '';
            $menu_header->save();

            // Redirect
            return redirect()->route('admin.menu.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Get the menu header
        $menu_header = MenuHeader::find($request->id);

        // Delete the menu header
        $menu_header->delete();

        // Redirect
        return redirect()->route('admin.menu.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Sort the resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        // Loop menu headers
        if(count($request->get('ids')) > 0) {
            foreach($request->get('ids') as $key=>$id) {
                $menu_header = MenuHeader::find($id);
                if($menu_header) {
                    $menu_header->num_order = $key + 2;
                    $menu_header->save();
                }
            }

            echo 'Berhasil mengurutkan data.';
        }
        else echo 'Terjadi kesalahan dalam mengurutkan data.';
    }
}
