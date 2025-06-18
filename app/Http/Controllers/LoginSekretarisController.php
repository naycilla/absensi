<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class LoginSekretarisController extends Controller
{
    public function login() 
    {
        if(Auth::check()) return redirect('/sekretaris/dashboard');
        else return view('sekretaris.login');
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

        if ($level != 2 ) return back()->with('loginError', 'Login gagal!');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect('/sekretaris/dashboard');

        }

        else return back()->with('loginError', 'Login gagal!');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/sekretaris');
    }
}
