<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Absensi;
use App\Models\DataSiswa;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function dashboard () {

        $kelas = count(Kelas::all());
        $siswa = count(DataSiswa::all());

        return view('operator.dashboard', compact('kelas', 'siswa'));
    }
    

}
