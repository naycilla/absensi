<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Absensi;
use App\Models\AbsensiDetail;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use function PHPUnit\Framework\isEmpty;

class SekretarisController extends Controller
{
    public function dashboard () {

        $tanggal =  Helpers::tanggal(Carbon::now()->format('Y-m-d'));
        $id_kelas = Auth::user()->data['id_kelas'];
        $kelas = Auth::user()->data->kelas['nama_kelas'];
        $jumlah = DataSiswa::where('id_kelas', $id_kelas)->count();
        $absensi = Absensi::where('id_kelas', $id_kelas)->orderBy('id', 'desc')->first();

        if($absensi == null)
        {
             $latest_tgl = ''; 
             $hadir = $sakit = $izin = $alpa = $dispen = 0;
        }
        else 
        {


            $latest_tgl = Helpers::tanggal($absensi->created_at);
                
            $hadir = $absensi->hadir;
            $sakit = $absensi->sakit;
            $izin = $absensi->izin + $absensi->dispen;
            $alpa = $absensi->alpa;
            

        }    
        return view('sekretaris.dashboard', compact('tanggal', 'kelas', 'jumlah', 'latest_tgl', 'hadir', 'sakit', 'izin', 'alpa'));
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

    public function hadir()
    {

        $id_kelas = Auth::user()->data['id_kelas'];
        $absensi = Absensi::where('id_kelas', $id_kelas)->orderBy('id', 'desc')->first();
        $hadir = AbsensiDetail::where('id_absensi', $absensi->id)->where('status', 5)->get();
        $tanggal = Helpers::tanggal($absensi->created_at);
                
        $detail = $absensi->hadir;

        return view('sekretaris.absensi.absen', compact('tanggal', 'hadir', 'detail', 'absensi'));

    }

    public function sakit()
    {

        $id_kelas = Auth::user()->data['id_kelas'];
        $absensi = Absensi::where('id_kelas', $id_kelas)->orderBy('id', 'desc')->first();
        $sakit = AbsensiDetail::where('id_absensi', $absensi->id)->where('status', 1)->get();
        $tanggal = Helpers::tanggal($absensi->created_at);
                
        $detail = $absensi->sakit;

        return view('sekretaris.absensi.absen', compact('tanggal', 'sakit', 'detail', 'absensi'));

    }

    public function izin()
    {

        $id_kelas = Auth::user()->data['id_kelas'];
        $absensi = Absensi::where('id_kelas', $id_kelas)->orderBy('id', 'desc')->first();
        $izin = AbsensiDetail::select('*')
                ->where('id_absensi', $absensi->id)
                ->where(function($query) {
                    return $query
                           ->where('status', '=', 2)
                           ->orWhere('status', '=', 4);
                   })
                ->get();
        $tanggal = Helpers::tanggal($absensi->created_at);
                
        $detail = $absensi->izin;

        return view('sekretaris.absensi.absen', compact('tanggal', 'izin', 'detail', 'absensi'));

    }

    public function alpa()
    {

        $id_kelas = Auth::user()->data['id_kelas'];
        $absensi = Absensi::where('id_kelas', $id_kelas)->orderBy('id', 'desc')->first();
        $alpa = AbsensiDetail::where('id_absensi', $absensi->id)->where('status', 3)->get();
        $tanggal = Helpers::tanggal($absensi->created_at);
                
        $detail = $absensi->alpa;

        return view('sekretaris.absensi.absen', compact('tanggal', 'alpa', 'detail', 'absensi'));

    }
}
