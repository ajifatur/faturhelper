<?php

namespace Ajifatur\FaturHelper\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use Ajifatur\FaturHelper\Models\User;

class CamouflageController extends \App\Http\Controllers\Controller
{
    /**
     * Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);
        
        // Get user
        $user = User::findOrFail($request->id);

        // Set session for the real account
        if(session()->exists('user') == false)
            session(['user' => Auth::user()->id]);

        // Camouflage
        Auth::login($user, true);

        // Return
        if(session('user') != Auth::user()->id)
            return redirect()->route('admin.dashboard')->with(['message' => 'Berhasil melakukan kamuflase akun.']);
    }

    /**
     * Logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Check the access
        has_access(__METHOD__, Auth::user()->role_id);
        
        // Get user
        $user = User::findOrFail(session('user'));

        // Camouflage
        Auth::login($user, true);

        // Return
        return redirect()->route('admin.dashboard')->with(['message' => 'Berhasil kembali ke akun semula.']);
    }
}
