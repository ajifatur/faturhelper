<?php

namespace Ajifatur\FaturHelper\Http\Controllers\API;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Ajifatur\FaturHelper\Models\Role;
use Ajifatur\FaturHelper\Models\User;

class UserController extends \App\Http\Controllers\Controller
{
    /**
     * Get user role.
     * 
     * @return \Illuminate\Http\Response
     */
    public function role()
    {
        $data = [];

        // Get roles
        $roles = Role::orderBy('is_admin','desc')->orderBy('num_order','asc')->get();

        // Loop roles
        foreach($roles as $key=>$role) {
            // Count users
            if(setting('multiple_roles') == 1) {
                $users = User::whereHas('roles', function (Builder $query) use ($role) {
                    return $query->where('role_id','=',$role->id);
                })->count();
            }
            else {
                $users = User::where('role_id','=',$role->id)->count();
            }

            // Push to data
            $data[] = [
                'name' => $role->name,
                'y' => $users
            ];
        }

        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $data
        ], 200);
    }

    /**
     * Get user status.
     * 
     * @return \Illuminate\Http\Response
     */
    public function status()
    {
        $data = [];

        // Loop statuses
        foreach(status() as $key=>$status) {
            // Count users
            $users = User::where('status','=',$status['key'])->count();

            // Push to data
            $data[] = [
                'name' => $status['name'],
                'y' => $users
            ];
        }

        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $data
        ], 200);
    }

    /**
     * Get user gender.
     * 
     * @return \Illuminate\Http\Response
     */
    public function gender()
    {
        $data = [];

        // Loop genders
        foreach(gender() as $key=>$gender) {
            // Count users
            $users = User::whereHas('attribute', function (Builder $query) use ($gender) {
                return $query->where('gender','=',$gender['key']);
            })->count();

            // Push to data
            $data[] = [
                'name' => $gender['name'],
                'y' => $users
            ];
        }

        // Response
        return response()->json([
            'message' => 'Success.',
            'data' => $data
        ], 200);
    }
}
