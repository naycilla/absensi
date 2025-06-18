<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{
    public function login(Request $request) 
    {
        
        if(Auth::check()) return redirect('/admin/dashboard');
        else return view('admin.login');
    }

    public function authenticate(Request $request) 
    {
        // $level = User::where('username', $request->username)->value('level');
        
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect('/admin/dashboard');

        }

        else return back()->with('loginError', 'Login gagal!');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/admin');
    }

}
