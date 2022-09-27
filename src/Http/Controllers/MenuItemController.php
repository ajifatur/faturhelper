<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturHelper\Models\MenuHeader;
use Ajifatur\FaturHelper\Models\MenuItem;

class MenuItemController extends \App\Http\Controllers\Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $header_id
     * @return \Illuminate\Http\Response
     */
    public function create($header_id)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // Get the menu header
        $menu_header = MenuHeader::find($header_id);

        // Get parent menu items
        $menu_parents = MenuItem::where('parent','=',0)->orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/menu-item/create', [
            'menu_header' => $menu_header,
            'menu_parents' => $menu_parents
        ]);
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
            'icon' => $request->parent == 0 ? 'required|max:200' : '',
            'active_conditions' => 'required',
            'parent' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Get the latest menu item
            $latest_menu_item = MenuItem::where('menuheader_id','=',$request->header_id)->orderBy('num_order','desc')->first();

            // Get the parent menu
            $menu_parent = MenuItem::find($request->parent);

            // Save the menu item
            $menu_item = new MenuItem;
            $menu_item->menuheader_id = $menu_parent ? $menu_parent->menuheader_id : $request->header_id;
            $menu_item->name = $request->name;
            $menu_item->route = $request->route;
            $menu_item->routeparams = $request->routeparams != '' ? $request->routeparams : '';
            $menu_item->icon = $request->icon;
            $menu_item->visible_conditions = $request->visible_conditions != '' ? $request->visible_conditions : '';
            $menu_item->active_conditions = $request->active_conditions != '' ? $request->active_conditions : '';
            $menu_item->parent = $request->parent;
            $menu_item->num_order = $latest_menu_item ? $latest_menu_item->num_order + 1 : 1;
            $menu_item->save();

            // Redirect
            return redirect()->route('admin.menu.index')->with(['message' => 'Berhasil menambah data.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $header_id
     * @param  int  $item_id
     * @return \Illuminate\Http\Response
     */
    public function edit($header_id, $item_id)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // Get the menu item
        $menu_item = MenuItem::findOrFail($item_id);

        // Get the menu header
        $menu_header = MenuHeader::find($header_id);

        // Get parent menu items
        $menu_parents = MenuItem::where('parent','=',0)->orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/menu-item/edit', [
            'menu_item' => $menu_item,
            'menu_header' => $menu_header,
            'menu_parents' => $menu_parents
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
            'icon' => $request->parent == 0 ? 'required|max:200' : '',
            'active_conditions' => 'required',
            'parent' => 'required',
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Get the parent menu
            $menu_parent = MenuItem::find($request->parent);

            // Update the menu item
            $menu_item = MenuItem::find($request->id);
            $menu_item->menuheader_id = $menu_parent ? $menu_parent->menuheader_id : $menu_item->menuheader_id;
            $menu_item->name = $request->name;
            $menu_item->route = $request->route;
            $menu_item->routeparams = $request->routeparams != '' ? $request->routeparams : '';
            $menu_item->icon = $request->icon;
            $menu_item->visible_conditions = $request->visible_conditions != '' ? $request->visible_conditions : '';
            $menu_item->active_conditions = $request->active_conditions != '' ? $request->active_conditions : '';
            $menu_item->parent = $request->parent;
            $menu_item->save();

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
        
        // Get the menu item
        $menu_item = MenuItem::find($request->id);

        // Delete the menu item
        $menu_item->delete();

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
        // Loop menu items
        if(count($request->get('ids')) > 0) {
            foreach($request->get('ids') as $key=>$id) {
                $menu_item = MenuItem::find($id);
                if($menu_item) {
                    $menu_item->num_order = $key + 1;
                    $menu_item->save();
                }
            }

            echo 'Berhasil mengurutkan data.';
        }
        else echo 'Terjadi kesalahan dalam mengurutkan data.';
    }
}
