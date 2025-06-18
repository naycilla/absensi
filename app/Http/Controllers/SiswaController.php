<?php

namespace App\Http\Controllers;

use App\Models\AbsensiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class SiswaController extends Controller
{
    public function dashboard() {

            $nama = Auth::user()->data['nama'];
            $kelas = Auth::user()->data->kelas['nama_kelas'];
            $absensi = AbsensiDetail::where('nisn', Auth::user()->data['nisn']);

            $hadir = AbsensiDetail::select('*')
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('nisn', Auth::user()->data['nisn'])
            ->where('status', 5)
            ->get();

            $absen = AbsensiDetail::select('*')
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('nisn', Auth::user()->data['nisn'])
            ->where(function($query) {
                return $query
                       ->where('status', '=', 1)
                       ->orWhere('status', '=', 2)
                       ->orWhere('status', '=', 3)
                       ->orWhere('status', '=', 4);
               })
            ->get();

            return view('siswa.dashboard', compact('nama', 'kelas', 'hadir', 'absen'));
    
    }

    public function bulan(Request $request)
    {
        // return $request;
        $bulan = $request->bulan;
        if(strlen($bulan) == 1) $bulan = "0" . $bulan;     

        // return view('siswa.dashboard', compact('nama', 'kelas', 'hadir', 'absen'));
        return redirect('/siswa/dashboard/'. $bulan);     
    }

    public function month(Request $request)
    {
        $bulan = $request->bulan;
        $nama = Auth::user()->data['nama'];
        $kelas = Auth::user()->data->kelas['nama_kelas'];
                
        $hadir = AbsensiDetail::select('*')
        ->whereMonth('created_at', '=', $bulan)
        ->where('nisn', Auth::user()->data['nisn'])
        ->where('status', 5)
        ->get();
        
        $absen = AbsensiDetail::select('*')
        ->whereMonth('created_at', '=' , $bulan)
        ->where('nisn', Auth::user()->data['nisn'])
        ->where(function($query) {
            return $query
                   ->where('status', '=', 1)
                   ->orWhere('status', '=', 2)
                   ->orWhere('status', '=', 3)
                   ->orWhere('status', '=', 4);
           })
        ->get();
        
        if($hadir->isEmpty() && $absen->isEmpty()) return redirect('/siswa/dashboard')->with('error', 'Data belum ditambahkan'); 
        else return view('siswa.dashboard', compact('nama', 'kelas', 'hadir', 'absen'));

    }

    public function download(Request $request)
    {
        $filepath = public_path('\storage\bukti/'.$request->file);

        if(file_exists($filepath)) return Response::download($filepath); 
        else return back()->with('error', 'Tidak ada bukti ditambahkan');
    
    }    
    
    public function back()
    {
        return back()->with('error', 'Tidak ada bukti ditambahkan');
    }

}
