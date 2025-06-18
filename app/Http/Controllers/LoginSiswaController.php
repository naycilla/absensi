<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginSiswaController extends Controller
{
    public function login() 
    {
        if(Auth::check()) return redirect('/siswa/dashboard');
        else return view('siswa.login');
    }

    public function authenticate(Request $request) 
    {
        $level = User::where('username', $request->username)->value('level');
        
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect('/siswa/dashboard');

        }

        else return back()->with('loginError', 'Login gagal!');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
