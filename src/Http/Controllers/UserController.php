<?php

namespace Ajifatur\FaturHelper\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\Helpers\DateTimeExt;
use Ajifatur\FaturHelper\Models\User;
use Ajifatur\FaturHelper\Models\UserAttribute;
use Ajifatur\FaturHelper\Models\UserAvatar;
use Ajifatur\FaturHelper\Models\Role;

class UserController extends \App\Http\Controllers\Controller
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

        // Get users
        if($request->query('role') == 0)
            $users = User::orderBy('role_id','asc')->get();
        else
            $users = User::where('role_id','=',$request->query('role'))->orderBy('role_id','asc')->get();

        // Get roles
        $roles = Role::orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/user/index', [
            'users' => $users,
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
        has_access(__METHOD__, Auth::user()->role_id);

        // Get roles
        $roles = Role::orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/user/create', [
            'roles' => $roles
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
            'birthdate' => 'required',
            'gender' => 'required',
            'country_code' => 'required',
            'phone_number' => 'required|numeric',
            'role' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|alpha_dash|min:4|unique:users',
            'password' => 'required|min:6',
            'status' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Save the user
            $user = new User;
            $user->role_id = $request->role;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->password = bcrypt($request->password);
            $user->remember_token = null;
            $user->access_token = access_token();
            $user->avatar = null;
            $user->status = $request->status;
            $user->last_visit = null;
            $user->save();

            // Save the user attribute
            $user_attribute = new UserAttribute;
            $user_attribute->user_id = $user->id;
            $user_attribute->birthdate = DateTimeExt::change($request->birthdate);
            $user_attribute->gender = $request->gender;
            $user_attribute->country_code = $request->country_code;
            $user_attribute->dial_code = dial_code($request->country_code);
            $user_attribute->phone_number = $request->phone_number;
            $user_attribute->save();
            
            // Upload the image
            if($request->photo_source != '') {
                $image = $request->photo_source;
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = date('Y-m-d-H-i-s').'.'.'png';
                File::put(public_path('assets/images/users'). '/' . $imageName, base64_decode($image));

                // Update the user avatar
                $user->avatar = $imageName;
                $user->save();

                // Save user avatar
                $user_avatar = new UserAvatar;
                $user_avatar->user_id = $user->id;
                $user_avatar->avatar = $user->avatar;
                $user_avatar->save();
            }

            // Redirect
            return redirect()->route('admin.user.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Get the user
        $user = User::findOrFail($id);

        // Get roles
        $roles = Role::orderBy('num_order','asc')->get();

        // View
        return view('faturhelper::admin/user/edit', [
            'user' => $user,
            'roles' => $roles
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
            'birthdate' => 'required',
            'gender' => 'required',
            'country_code' => 'required',
            'phone_number' => 'required|numeric',
            'role' => 'required',
            'email' => [
                'required', 'email', Rule::unique('users')->ignore($request->id, 'id')
            ],
            'username' => [
                'required', 'alpha_dash', 'min:4', Rule::unique('users')->ignore($request->id, 'id')
            ],
            'password' => $request->password != '' ? 'required|min:6' : '',
            'status' => 'required'
        ]);
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update the user
            $user = User::find($request->id);
            $user->role_id = $request->role;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->status = $request->status;
            $user->save();

            // Update or save the user attribute
            $user_attribute = UserAttribute::where('user_id','=',$user->id)->first();
            if(!$user_attribute) $user_attribute = new UserAttribute;
            $user_attribute->user_id = $user->id;
            $user_attribute->birthdate = DateTimeExt::change($request->birthdate);
            $user_attribute->gender = $request->gender;
            $user_attribute->country_code = $request->country_code;
            $user_attribute->dial_code = dial_code($request->country_code);
            $user_attribute->phone_number = $request->phone_number;
            $user_attribute->save();
            
            // Upload the image
            if($request->photo_source != '') {
                $image = $request->photo_source;
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = date('Y-m-d-H-i-s').'.'.'png';
                File::put(public_path('assets/images/users'). '/' . $imageName, base64_decode($image));

                // Update the user avatar
                $user->avatar = $imageName;
                $user->save();

                // Save user avatar
                $user_avatar = new UserAvatar;
                $user_avatar->user_id = $user->id;
                $user_avatar->avatar = $user->avatar;
                $user_avatar->save();
            }

            // Redirect
            return redirect()->route('admin.user.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Get the user
        $user = User::find($request->id);

        // Check user ID
        if($user->id == 1) {
            // Redirect
            return redirect()->route('admin.user.index')->with(['message' => 'Tidak bisa menghapus akun default ini.']);
        }

        // Delete the user
        $user->delete();

        // Delete the user attribute
        if($user->attribute) {
            $user->attribute->delete();
        }

        // Delete the user avatars
        if(count($user->avatars) > 0) {
            $user_avatars = UserAvatar::where('user_id','=',$user->id)->delete();
        }

        // Redirect
        return redirect()->route('admin.user.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteBulk(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);

        // Explode ids
        $ids = explode(",", $request->ids);

        if(count($ids) > 0) {
            foreach($ids as $id) {
                if($id != 1) {
                    // Get the user
                    $user = User::find($id);

                    // Delete the user
                    $user->delete();

                    // Delete the user attribute
                    if($user->attribute) {
                        $user->attribute->delete();
                    }

                    // Delete the user avatars
                    if(count($user->avatars) > 0) {
                        $user_avatars = UserAvatar::where('user_id','=',$user->id)->delete();
                    }
                }
            }

            // Redirect
            if(in_array(1, $ids) && count($ids) > 1) {
                return redirect()->route('admin.user.index')->with(['message' => 'Berhasil menghapus data, tetapi tidak bisa menghapus akun default.']);
            }
            elseif(in_array(1, $ids) && count($ids) == 1) {
                return redirect()->route('admin.user.index')->with(['message' => 'Tidak bisa menghapus akun default.']);
            }
            else {
                return redirect()->route('admin.user.index')->with(['message' => 'Berhasil menghapus data.']);
            }
        }
    }
}
