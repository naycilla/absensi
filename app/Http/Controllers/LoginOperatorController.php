<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginOperatorController extends Controller
{
    public function login() 
    {
        if(Auth::check()) return redirect('/operator/dashboard');
        else return view('operator.login');
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
 
            return redirect('/operator/dashboard');

        }

        else return back()->with('loginError', 'Login gagal!');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/operator');
    }

}
