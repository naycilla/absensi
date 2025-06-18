<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard () {

        $kelas = count(Kelas::all());
        $siswa = count(DataSiswa::all());
        $operator = count(User::where('level', 3)->get());
        $admin = count(User::where('level', 4)->get());

        return view('operator.dashboard', compact('kelas', 'siswa', 'operator', 'admin'));
    }
    
} 
