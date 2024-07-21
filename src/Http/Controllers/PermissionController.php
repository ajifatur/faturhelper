<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturHelper\Models\Permission;
use Ajifatur\FaturHelper\Models\Role;

class PermissionController extends \App\Http\Controllers\Controller
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

        // Get permissions
        if($request->query('default') == 1)
            $permissions = Permission::where('default','=',1)->orderBy('num_order','asc')->get();
        else
            $permissions = Permission::where('default','=',0)->orderBy('num_order','asc')->get();

        // Get routes
        $routes = collect(Route::getRoutes())->map(function($route) use($request) {
            if(is_int(strpos($route->getActionName(), ($request->query('default') == 1 ? 'Ajifatur\FaturHelper\Http\Controllers' : 'App\Http\Controllers')))) {
                return [
                    'actionName' => str_replace('@','::',$route->getActionName()),
                ];
            }
        });

        // Push to codes
        $codes = [];
        foreach($routes as $route) {
            if($route != null) {
                if($request->query('default') == 1)
                    array_push($codes, substr($route['actionName'],1,strlen($route['actionName'])-1));
                else
                    array_push($codes, $route['actionName']);
            }
        }

        foreach($permissions as $key=>$permission) {
            $permissions[$key]->isAvailable = in_array($permission->code, $codes);
        }

        // Get roles
        $roles = Role::orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/permission/index', [
            'permissions' => $permissions,
            'roles' => $roles,
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

        // Get routes
        $routes = collect(Route::getRoutes())->map(function($route) {
            if(is_int(strpos($route->getActionName(), 'App\Http\Controllers'))) {
                return [
                    'method' => $route->methods()[0],
                    'actionName' => str_replace('@','::',$route->getActionName()),
                ];
            }
        });

        // View
        return view('faturhelper::admin/permission/create', [
            'routes' => $routes
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
            'code' => 'required|unique:permissions'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Get the latest permission
            $latest_permission = Permission::where('default','=',0)->orderBy('num_order','desc')->first();

            // Save the permission
            $permission = new Permission;
            $permission->name = $request->name;
            $permission->code = $request->code;
            $permission->default = 0;
            $permission->num_order = $latest_permission ? $latest_permission->num_order + 1 : 1;
            $permission->save();

            // Redirect
            return redirect()->route('admin.permission.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Get the permission
        $permission = Permission::findOrFail($id);

        // Get routes
        $routes = collect(Route::getRoutes())->map(function($route) {
            if(is_int(strpos($route->getActionName(), 'App\Http\Controllers'))) {
                return [
                    'method' => $route->methods()[0],
                    'actionName' => str_replace('@','::',$route->getActionName()),
                ];
            }
        });

        // Check permission whether is default
        if($permission->default === 1) {
            // Redirect
            return redirect()->route('admin.permission.index', ['default' => 1])->with(['message' => 'Tidak bisa mengubah hak akses yang default.']);
        }

        // View
        return view('faturhelper::admin/permission/edit', [
            'permission' => $permission,
            'routes' => $routes
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
            'code' => [
                'required', Rule::unique('permissions')->ignore($request->id, 'id')
            ],
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update the permission
            $permission = Permission::find($request->id);
            $permission->name = $request->name;
            $permission->code = $request->code;
            $permission->default = 0;
            $permission->save();

            // Redirect
            return redirect()->route('admin.permission.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Get the permission
        $permission = Permission::find($request->id);

        // Check permission whether is default
        if($permission->default === 1) {
            // Redirect
            return redirect()->route('admin.permission.index', ['default' => 1])->with(['message' => 'Tidak bisa menghapus hak akses yang default.']);
        }

        // Delete the permission
        $permission->delete();

        // Redirect
        return redirect()->route('admin.permission.index')->with(['message' => 'Berhasil menghapus data.']);
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

        // Get permissions
        $permissions = Permission::where('default','=',0)->orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/permission/reorder', [
            'permissions' => $permissions
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
        // Loop permissions
        if(count($request->get('ids')) > 0) {
            foreach($request->get('ids') as $key=>$id) {
                $permission = Permission::find($id);
                if($permission) {
                    $permission->num_order = $key + 1;
                    $permission->save();
                }
            }

            echo 'Berhasil mengurutkan data.';
        }
        else echo 'Terjadi kesalahan dalam mengurutkan data.';
    }

    /**
     * Change the resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // Get the role
        $role = Role::find($request->role);

        // Check role hierarchy
        if($role->num_order >= Auth::user()->role->num_order) {
            // Get the permission
            $permission = Permission::find($request->permission);

            // Change status
            if($permission) {
                $permission->roles()->toggle($request->role);
                echo 'Berhasil mengganti status hak akses.';
            }
            else {
                echo 'Terjadi kesalahan dalam mengganti status hak akses.';
            }
        }
        else {
            echo 'Tidak bisa mengganti status hak akses pada tingkatan role yang lebih tinggi.';
        }
    }
}
