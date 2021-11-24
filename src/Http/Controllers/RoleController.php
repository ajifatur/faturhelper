<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturHelper\Models\Role;

class RoleController extends \App\Http\Controllers\Controller
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

        // Get roles
        $roles = Role::orderBy('num_order','asc')->get();

        // View
        return view(custom_view('admin/role/index'), [
            'roles' => $roles
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
        has_access(method(__METHOD__), Auth::user()->role_id);

        // View
        return view(custom_view('admin/role/create'));
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
            'code' => 'required|alpha_dash|unique:roles',
            'is_admin' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Get the latest role
            $latest_role = Role::orderBy('num_order','desc')->first();

            // Save the role
            $role = new Role;
            $role->name = $request->name;
            $role->code = $request->code;
            $role->is_admin = $request->is_admin;
            $role->num_order = $latest_role ? $latest_role->num_order + 1 : 1;
            $role->save();

            // Redirect
            return redirect()->route('admin.role.index')->with(['message' => 'Berhasil menambah data.']);
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
        has_access(method(__METHOD__), Auth::user()->role_id);

        // Get the role
        $role = Role::findOrFail($id);

        // View
        return view(custom_view('admin/role/edit'), [
            'role' => $role
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
                'required', 'alpha_dash', Rule::unique('roles')->ignore($request->id, 'id')
            ],
            'is_admin' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update the role
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->code = $request->code;
            $role->is_admin = $request->is_admin;
            $role->save();

            // Redirect
            return redirect()->route('admin.role.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        has_access(method(__METHOD__), Auth::user()->role_id);
        
        // Get the role
        $role = Role::find($request->id);

        // Delete the role
        $role->delete();

        // Redirect
        return redirect()->route('admin.role.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
