<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturHelper\Models\MenuHeader;
use Ajifatur\FaturHelper\Models\MenuItem;
use Ajifatur\FaturHelper\Models\Role;

class MenuItemController extends \App\Http\Controllers\Controller
{
    public $getMethodRoutes, $indexRoutes;

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

        // Get roles
        $roles = Role::orderBy('num_order','asc')->get();

        // Configure routes
        self::routes();

        // View
        return view('faturhelper::admin/menu-item/create', [
            'menu_header' => $menu_header,
            'menu_parents' => $menu_parents,
            'roles' => $roles,
            'getMethodRoutes' => $this->getMethodRoutes,
            'indexRoutes' => $this->indexRoutes,
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

            // Set route params
            $route_params = '';
            $route_params_temp = [];
            if(count(array_filter($request->params)) > 0 && count(array_filter($request->values)) > 0) {
                for($i=0; $i<count($request->params); $i++) {
                    if($request->params[$i] != '') {
                        $param = preg_replace("/[^a-zA-Z0-9]+/", "", $request->params[$i]);
                        $route_params_temp[$param] = $request->values[$i];
                    }
                }
                $route_params = json_encode($route_params_temp);
            }

            // Get the parent menu
            $menu_parent = MenuItem::find($request->parent);

            // Save the menu item
            $menu_item = new MenuItem;
            $menu_item->menuheader_id = $menu_parent ? $menu_parent->menuheader_id : $request->header_id;
            $menu_item->name = $request->name;
            $menu_item->route = $request->route;
            $menu_item->routeparams = $route_params;
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

        // Get roles
        $roles = Role::orderBy('num_order','asc')->get();

        // Configure routes
        self::routes();

        // View
        return view('faturhelper::admin/menu-item/edit', [
            'menu_item' => $menu_item,
            'menu_header' => $menu_header,
            'menu_parents' => $menu_parents,
            'roles' => $roles,
            'getMethodRoutes' => $this->getMethodRoutes,
            'indexRoutes' => $this->indexRoutes,
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

            // Set route params
            $route_params = '';
            $route_params_temp = [];
            if(count(array_filter($request->params)) > 0 && count(array_filter($request->values)) > 0) {
                for($i=0; $i<count($request->params); $i++) {
                    if($request->params[$i] != '') {
                        $param = preg_replace("/[^a-zA-Z0-9]+/", "", $request->params[$i]);
                        $route_params_temp[$param] = $request->values[$i];
                    }
                }
                $route_params = json_encode($route_params_temp);
            }

            // Update the menu item
            $menu_item = MenuItem::find($request->id);
            $menu_item->menuheader_id = $menu_parent ? $menu_parent->menuheader_id : $menu_item->menuheader_id;
            $menu_item->name = $request->name;
            $menu_item->route = $request->route;
            $menu_item->routeparams = $route_params;
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

    /**
     * Configure Routes.
     *
     * @return void
     */
    public function routes()
    {
        // Get and filter routes
        $routes = collect(Route::getRoutes())->map(function($route) {
            if($route->getName() != '' && in_array('web', $route->middleware()) && $route->methods()[0] == 'GET' && $route->getName() != 'auth.login') {
                return [
                    'name' => $route->getName(),
                    'parameterName' => $route->parameterNames()
                ];
            }
        });

        // Loop and plot routes
        $getMethodRoutes = [];
        $indexRoutes = [];
        foreach($routes as $route) {
            if($route != null && count($route['parameterName']) == 0) {
                array_push($getMethodRoutes, $route['name']);
                if(is_int(strpos($route['name'], '.index'))) array_push($indexRoutes, $route['name']);
            }
        }
        $this->getMethodRoutes = $getMethodRoutes;
        $this->indexRoutes = $indexRoutes;
    }
}
